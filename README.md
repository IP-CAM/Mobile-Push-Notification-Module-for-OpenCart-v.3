# mpn-opencart3
Mobile Push Notification Module for OpenCart3 /w Firebase Cloud Messaging

Module for send push notification for your e-commerce mobile application for free from OpenCart3 admin dasboard!
Module uses cURL for send notification data to Firebase(It works with topic-subscribe mechanism).

### mpn.twig
```
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status">{{ firebase_sender_id }}</label>
                        <div class="col-sm-10">
                            <input name="module_firebase_sender_id" id="input-firebase-sender-id" type="text" value="<FIREBASE-SENDER-ID>" readonly class="form-control">
                        </div>
                    </div>
<div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status">{{ firebase_key }}</label>
                        <div class="col-sm-10">
                            <input name="module_firebase_key" id="input-firebase-key" type="text" value="<FIREBASE-SERVER-LEGACY-KEY" readonly class="form-control">
                        </div>
                    </div>
```

<img src="https://github.com/cnkay/-mpn-opencart3-/blob/master/images/admin_1.png">
<img src="https://github.com/cnkay/-mpn-opencart3-/blob/master/images/admin_2.png">
<img src="https://github.com/cnkay/-mpn-opencart3-/blob/master/images/admin_3.png">
