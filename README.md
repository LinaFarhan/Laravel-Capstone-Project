منصة للمساعدات الانسانية
تقدم الخدمات للمستفيد من خلال الطلباتى التي يسجلها ثم توزع في التوزيعات بواسطة المتطوع 
هذا ما تشملة المنصة
مستفيد
ومتطوع
ومسؤول

مبنية ب
-laravel
-php
-xammp
-mysql
-vue.js
--------------------------------


*DATABASE

 -Migrations

 1-users_table
 2-donation_table
 3-aid_requests_table
 4-distributions_table


 -Factories

1-UserFactory
2-DonationFactory
3-AidRequestFactory
4-DistributionFactory

 -Seeders

 1-UserSeeder
2-DonationSeeder
3-AidRequestSeeder
4-DistributionSeeder
5-DatabaseSeeder
-----------------------------------------------
- MODELS

 1-User
 2-Donation
 3-AidRequest
 4-Distribution
--------------------------------------------------------------
 *SECURITY

 -Middleware
 ( kernel.php)
 1-AdminMiddleware
 2-VolunteerMiddleware
 3-BeneficiaryMiddleware
 ------
 فائدة middleware
 يعتبر الحارس على التطبيق
 تتحق من الصلاحيات قبل الوصول الى الروتر
 ترجع المستخدمين الغير المصرح لهم الى الصفحات المناسبة
 تضمن الامان ومنع الوصول غير المصرح بع 
 --------------
الفائدة من ( kernel.php)
نضمن فيه middleware
يدير middlewareالعام الذي ينطبق عل جميع الطلبات
يحدد لمجموعات routes 
يحدد ذات الاولوية التي تعمل اولا


 -Policies
 
  1-UserPolicy
  2-DonationPolicy
  3-AidRequestPolicy
  4-DistributionPolicy
 
 الفائدة منها
 تحكم دقيق في الصلاحيات على مستوى الموديل
 اعادة استخدام الكود  لتحقق من الصلاحيات
 قراءة وسهولة صيانة لقواعد الصلاحيات

 -Auth
-Providers
المكان الذي تسجل فيه سيايات الصاحيات لتطبيق
   -AuthServiceProvider.php
 -----------------------------------------------------------------  
 *CONTROLLERS

 -Controllers

 1-Admin
   1-AdminController
   2-UserController
   3-DonationController
   4-AidRequestController
   5-DistributionController
 2-Volunteer
   1-VolunteerController
   2-DistributionController
3-Beneficiary
   1-BeneficiaryController
   2-AidRequestController
4-APi
   1-Beneficiary
     -AidRequestController
   2-Volunteer
     -DistributionController
 5-NotifictionController    

 -Requestes(form)

 1-StoreAidRequestRequest
 2-UpdateAidRequestRequest
 3-StoreDonationRequest
 4-UpdateDistributionRequest

6-Notification
(config/notification.php->channels)
   1-DonationReceivedNotrification
   2-AidRequestDoniedNotification
   3-AidRequestApprovedNotification 
   4-DistributionAssignedNotification
*الخلاصة 
نظام اشعارات 
جدول في قاعدة البيانات-علاقات في المودل
 اشعارات للseeder,factory
 تحكم كامل لادارة الاشعارات
 واجهة لعرض الاشعارات 
 مكون vue.jsللاشعارات العاجلة
دعم real-timeباستخدامlaravel echo

 *VIEWS
 -Views
 *Blade
1- Admin

  1- dashboard.blade.php
   2-users
    -index.blade.php

   3-donnations
    -index.blade.php

   4-aid-requests
     -index.blade.php

   5-distributions
    -index.blade.php
    -show.blade.php
  

 2-volunteer

  1- dashboard.blade.php

  2-distributions
    -index.blade.php
    -show.blade.php

 3-beneficiary

  1- dashboard.blade.php

  2-aid-requests
   -create.blade.php
   -show.blade.php

 4-layout
 1-app.blade.php
 2-guest.blade.php
 --------
 -Vue
 js-
  -Components
  1-Admin
   -StatsDashboard.vue
   -Recentivities.vue

  2-Volunteer
  -DistributionList.vue
  -DistributionStatus.vue

  3-Beneficiary
  -AidRequestsForm.vue
  -RequestHistory.vue

  4-Shared
  -NotifiactionToast.vue
  -FileUpload.vue
  -StatusBadge.vue

  5-UI
  -Modal.vue
  -Alert.vue

 -Styling
 -app.css
 ---------------------------------------------------------------
 *Route
 -Api.php
 -web.php
 -api._v1.php

 *TESTS
 -Unit Tests
-Feature  
 -AdminDasboardTest
 -BeneficiaryAidRequestTest
 -VolunteerDitributionTest
 -AuthenticationTest
 -ApiTest
 

 *RUN
 -Build
 -Serve
 -Optimize
 
 *DOCUMANTION
 -README
 -API DOCS
 -Presentation
