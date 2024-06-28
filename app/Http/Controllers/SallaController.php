<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
use Illuminate\Support\str;
class SallaController extends Controller
{

    public function easyMode(Request $request)
    {
        $apiUrl = env('WHATSAPP_API_URL');
        $accessToken = env('WHATSAPP_ACCESS_TOKEN');
        $instanceId = env('WHATSAPP_INSTANCE_ID');
        logger($request->all());
        Log::info('hi0000000000000000000000000000000');
        $eventType = $request->input('event');


        if($eventType == 'abandoned.cart')
        {
            $merchantId = $request->input('merchant');
            $customerName = $request->input('data.customer.name');
            $checkoutUrl = $request->input('data.checkout_url');


             $store = DB::table('store')->where('merchant_id',$merchantId)->first();

                if($store)
                {

                if($store->access_token && $store->instance_id)
                {
                    $storeMobile = str_replace('+','',$store->mobile);
                                    Http::timeout(60)->post("{$apiUrl}/send", [
                                    'number' => $storeMobile,
                                    'type' => 'text',
                                    'message' => "مرحبًا {$customerName} 🌟

                نود أن نذكرك بأن هناك بعض المنتجات الرائعة بانتظارك في سلة التسوق الخاصة بك على متجرنا! 🛒

                لقد لاحظنا أنك لم تكمل عملية الشراء بعد، وسنكون سعداء بمساعدتك إذا كنت تواجه أي صعوبة. لا تفوت الفرصة للحصول على منتجاتك المفضلة قبل نفاذ الكمية.

                يمكنك إكمال عملية الشراء بسهولة عبر الرابط التالي:$checkoutUrl 💳

                إذا كانت لديك أي استفسارات أو تحتاج إلى مساعدة إضافية، فلا تتردد في التواصل معنا. فريق الدعم لدينا هنا لمساعدتك على مدار الساعة 📞💬.

                شكرًا لتسوقك معنا. نتطلع دائمًا لتقديم أفضل الخدمات لك.

                مع أطيب التحيات،
                فريق دعم بوت واتساب للتنبيهات",
                                    'instance_id' => $store->instance_id,
                                    'access_token' => $store->access_token,
                                    ]);

                }
            }

        }

        if($eventType == 'order.created')

        {
            $statusName = $request->input('data.status.name');
            $customerName = $request->input('data.customer.first_name');
            $customerPhoneNumber =$request->input('data.customer.mobile_code');
            $customerPhoneCode =  $request->input('data.customer.mobile');
            $storeName = $request->input('data.store.name.ar');
            $items = $request->input('data.items');

            $itemName = $items[0]['name'];
            $itemThumbnail =  $request->input('data.items.0.product.thumbnail');
            $customerPhoneWithplus = "$customerPhoneNumber"."$customerPhoneCode";
            $customerPhone  = str_replace('+', '', $customerPhoneWithplus);
            Log::info("item thumbanil : $itemThumbnail");


            // $message = "عزيزي $customerName\nلقد قمت بطلب $itemName\nحلة الطلب $statusName";
            $message = "✨ مرحباً عزيزي $customerName ،

شكرًا جزيلاً على طلبك من متجرنا! 🎉
نحن سعيدون للغاية باختيارك لنا، ونتمنى أن تستمتع بمنتجك الجديد '$itemName' الذي طلبته.

🚀 حالة الطلب الحالية: $statusName

نحن نعمل بجد للتأكد من أن تجربتك معنا تكون رائعة من البداية إلى النهاية. إذا كان لديك أي استفسار أو تحتاج إلى مساعدة، لا تتردد في التواصل معنا.

📦 سيتم إعلامك بمجرد شحن طلبك، لذا تابع البريد الإلكتروني أو الرسائل النصية للحصول على تحديثات الشحن.

شكراً مرة أخرى لكونك جزءاً من عائلتنا! 💖

تحياتي،
$storeName";

                // check if sending by store owner number active or not
            $merchantId = $request->input('merchant');
            $store = DB::table('store')->where('merchant_id', $merchantId)->first();

            if($store->mobile_status)
            {

                $storeMobile = str_replace('+','',$store->mobile);
                        // send request to whatsapp api  to send message to the customer
                Http::timeout(60)->post("{$apiUrl}/send", [
                'number' => $storeMobile,
                'type' => 'text',
                'message' => $message,
                'media_url' => "$itemThumbnail",
                'instance_id' => $store->instance_id,
                'access_token' => $store->access_token,
                ]);

            } else
            {

                            // send request to whatsapp api  to send message to the customer
            Http::timeout(60)->post("{$apiUrl}/send", [
            'number' => $customerPhone,
            'type' => 'text',
            'message' => $message,
            'media_url' => "$itemThumbnail",
            'instance_id' => $instanceId,
            'access_token' => $accessToken,
            ]);

            }


        }

        if($eventType == 'order.updated')
        {
            // mine 18653216348
            $statusName = $request->input('data.status.name');
            $customerName = $request->input('data.customer.first_name');
            $items = $request->input('data.items');
            $itemName = $items[0]['name'];
            $customerPhoneNumber =$request->input('data.customer.mobile_code');
            $customerPhoneCode =  $request->input('data.customer.mobile');
            $customerPhoneWithplus = "$customerPhoneNumber"."$customerPhoneCode";
            $customerPhone  = str_replace('+', '', $customerPhoneWithplus);

            $message = "عزيزي $customerName\nلقد تم تحديث حالة الطلب  $itemName\nحلة الطلب $statusName";
            // send request to whatsapp api  to send message to the customer
            Http::timeout(60)->post("{$apiUrl}/send", [
            'number' => '18653216348',
            'type' => 'text',
            'message' => $message,
            'instance_id' => $instanceId,
            'access_token' => $accessToken,

        ]);



        }

         if($eventType == 'app.settings.updated')
         {

            $merchantId = $request->input('merchant');
            $moblieStatus = $request->input('data.settings.activeMerchantNumber');

            DB::table('store')->update(
                [
                    'mobile_status' => $moblieStatus
                ]
            );

            if($moblieStatus)
            {
                $store = DB::table('store')->where('merchant_id',$merchantId)->first();

                if($store)
                {

                if($store->access_token && $store->instance_id)
                {
                    $storeMobile = str_replace('+','',$store->mobile);
                    Http::timeout(60)->post("{$apiUrl}/send", [
                    'number' => $storeMobile,
                    'type' => 'text',
                    'message' => "مرحبًا {$store->name} 🌟

نود أن نعبّر لك عن سعادتنا بتفعيلك خاصية إرسال الرسائل عبر رقمك الشخصي في تطبيق \"بوت واتساب للتنبيهات\" على متجر سلة! 🎉

بتفعيل هذه الخاصية، ستحظى بتواصل مباشر وشخصي مع عملائك من خلال رقمك الخاص، مما يعزز من ثقتهم بك ويسهم في تقديم تجربة شرائية مميزة لهم. هذه الخطوة ستمكنك من إرسال التنبيهات، تحديثات الطلبات، والعروض الخاصة بشكل أسرع وأكثر فعالية.

إذا كانت لديك أي استفسارات أو تحتاج إلى مساعدة إضافية، فلا تتردد في التواصل معنا. فريق الدعم لدينا هنا لمساعدتك على مدار الساعة 📞💬.

شكرًا لثقتك بنا. نتطلع دائمًا لتقديم أفضل الخدمات لك ولعملائك.

مع أطيب التحيات،
فريق دعم بوت واتساب للتنبيهات",
                    'instance_id' => $instanceId,
                    'access_token' => $accessToken,
                    ]);

                } else
                {
                    $user = DB::table('sp_users')->where('email',$store->email)->first();

                    if($user)
                    {

                                $team = DB::table('sp_team')->where('owner',$user->id)->first();

                                if($team)
                                {
                                    $accessToken = $team->ids;
                                    $accounts = DB::table('sp_accounts')->where('team_id',$team->id)->first();
                                    if($accounts)
                                    {
                                        $instanceId = $accounts->token;
                                        DB::table('store')->update(
                                            [
                                                'access_token' => $accessToken,
                                                'instance_id' => $instanceId
                                            ]
                                        );

                                    }


                                }




                    }






                }

                }





            }

             return response()->json(['message' => 'okay ! :)'], 200);

         }

        if($eventType == 'app.store.authorize')
        {
            $data = $request->input('data');
            $appAccessToken = $data['access_token'];

            $response =  Http::withToken($appAccessToken)->get('https://api.salla.dev/admin/v2/oauth2/user/info');
            $result = $response->body();
            // Decode the JSON string into a PHP associative array
                $data = json_decode($result, true);

                // Check if decoding was successful and the required key exists
                if ($data && isset($data['data'])) {
                    $mobileNumber = $data['data']['mobile'];
                    $email = $data['data']['email'];
                    $name = $data['data']['name'];
                    $merchantId = $data['data']['merchant']['id'];

                    $storeId = $data['data']['id'];
                            $storePhone = str_replace('+','',$mobileNumber);



                    // check if store is exsit

                    $store = DB::table('store')->where('store_id', $storeId)->first();

                    if($store)
                    {



                               // send request to whatsapp api  to send message to the customer
                    Http::timeout(60)->post("{$apiUrl}/send", [
                    'number' => $storePhone,
                    'type' => 'text',
                    'message' => "🎉 أهلاً وسهلاً بك من جديد! 🎉
مرحباً [اسم صاحب المتجر]،

يسعدنا جداً رؤيتك مرة أخرى! 🌟 نشكرك على إعادة تنصيب برنامجنا ونتطلع إلى مساعدتك في تحقيق نجاحات جديدة مع متجرك على منصة سلة. 🛒

إذا كنت بحاجة إلى أي مساعدة أو لديك أي استفسارات، لا تتردد في التواصل معنا. نحن هنا دائماً لدعمك! 🤝

نتمنى لك تجربة رائعة ومليئة بالنجاحات! 🚀

مع أطيب التحيات،
سمارت 💼",
                    'instance_id' => $instanceId,
                    'access_token' => $accessToken,

                ]);





                    } else {

                            // save store data to database
                            DB::table('store')->insert([
                                'store_id' =>$storeId,
                                'merchant_id' => $merchantId,
                                'name' => $name,
                                'email' => $email,
                                'mobile' => $mobileNumber,
                                'mobile_status' => 0
                            ]);


                                            // start section
                            $randomNumberId = rand(99999,9999999);
                            $tempName = $name . '_' . $randomNumberId;
                            $newUserName = $tempName;
                            $newEmail = $email;



                            $newPassword = Str::random(25);
                            $hashedPassword = md5($newPassword);



                            $user = DB::table('sp_users')->where('fullname', 'poepoe')->first();

                            // check if the user is exsit or not and handle if it is not exsit
                            if(!$user){
                                Log::info('user does not exsit');
                                return  'coming soon';
                            }

                            DB::table('sp_users')
                                ->where('id', $user->id)
                                ->update([
                                    'fullname' => $newUserName,
                                    'username' => $newUserName,
                                    'email'    => $newEmail,
                                    'password' => $hashedPassword

                                ]);

                               // send request to whatsapp api  to send message to the customer
                    Http::timeout(60)->post("{$apiUrl}/send", [
                    'number' => $storePhone,
                    'type' => 'text',
                    'message' => "مرحبًا [اسم صاحب المتجر] 🌟،

شكرًا لتثبيت تطبيق \"بوت واتساب للتنبيهات\" على متجر سلة! 🎉 نحن سعداء بانضمامك إلينا ونتطلع إلى مساعدتك في تحسين تواصلك مع عملائك.

لقد قمنا بإنشاء حساب خاص بك لتسهيل العملية. كل ما عليك القيام به هو اتباع الخطوات البسيطة التالية:

قم بتسجيل الدخول:
رابط تسجيل الدخول:https://dl1s.co/login
اسم المستخدم: {$newUserName}
كلمة المرور: {$newPassword}
تفعيل الربط مع رقمك:
بعد تسجيل الدخول، ستجد رمز QR على لوحة التحكم. قم بمسح هذا الرمز باستخدام تطبيق واتساب الخاص بك لتفعيل الربط مع رقمك الشخصي.
استمتع بالتواصل السريع والفعال:
الآن يمكنك إرسال التنبيهات والتحديثات إلى عملائك مباشرة من خلال رقمك الشخصي، مما يعزز من تجربتهم ويزيد من رضاهم.
إذا كانت لديك أي استفسارات أو تحتاج إلى مساعدة إضافية، فريق الدعم لدينا هنا لمساعدتك على مدار الساعة 📞💬.

نحن متحمسون للعمل معك ونتطلع إلى تقديم أفضل الخدمات لك ولعملائك.

مع أطيب التحيات،
فريق دعم بوت واتساب للتنبيهات",
                    'instance_id' => $instanceId,
                    'access_token' => $accessToken,

                ]);


                    }






                    Log::info( "store: $result");

                    Log::info( $mobileNumber);








                } else {
                    echo "Mobile number not found.";
                }




                }
          // Check the event type
        if ($eventType === 'customer.otp.request') {
            // Extract the code from the nested data object
            $code = $request->input('data.code');
            $contact = $request->input('data.contact');

            $customerPhone  = str_replace('+', '', $contact);

            Log::info("OTP Code: $code, Contact: $contact");
                // send the code throw whatsapp
            Http::timeout(60)->post("{$apiUrl}/send", [
            'number' => $customerPhone,
            'type' => 'text',
            'message' => "hi your salla code is : $code",
            'instance_id' => $instanceId,
            'access_token' => $accessToken,

        ]);


        }





        return response()->json(['message' => 'okay ! :)'], 200);

    }


}

















