<?php

class ControllerExtensionModuleMpn extends Controller {

    private $error = array();
    public function index() {
        $this->load->language('extension/module/mpn');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if(isset($_POST['save_form'])) {
                $this->model_setting_setting->editSetting('module_mpn', $this->request->post);
                $this->session->data['success'] = $this->language->get('text_success');

                $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
            }

        }
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            if(isset($_POST['notify_form'])) {
                $ch = curl_init();
                $firebase_sender_id = "";
                $firebase_server_key = $this->request->post['module_firebase_key'];
                $firebase_notification_title=$this->request->post['module_notification_title'];
                $firebase_notification_message=$this->request->post['module_notification_message'];

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n\t\"data\": {\n    \"title\":\"$firebase_notification_title\",\n\t\t\"message\":\"$firebase_notification_message\"\n    },\n  \"to\": \"/topics/topic\",\n\t\"priority\": \"high\"\n}");

                $headers = array();
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Authorization: key='.$firebase_server_key;
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);

                echo '<div class="alert alert-success alert-dismissable" id="success-alert" style="margin: 10px">';
                echo '<strong>Notification sent to all mobile users!</strong>';
                echo '</div>';
                //$this->session->data['success'] = $this->language->get('text_notification_success');
                //$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
            }

        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/mpn', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/module/mpn', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        if (isset($this->request->post['module_mpn_status'])) {
            $data['module_mpn_status'] = $this->request->post['module_mpn_status'];
        } else {
            $data['module_mpn_status'] = $this->config->get('module_mpn_status');
        }
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['module_mpn_success']=false;
        $this->response->setOutput($this->load->view('extension/module/mpn', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/mpn')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

}
