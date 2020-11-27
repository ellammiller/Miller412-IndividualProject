=== Calorie Calculator ===
Contributors: zubaer_ahammed
Tags: calorie calculator, calorie, calorie calculator, diet control, weight loss
Requires at least: 3.5
Tested up to: 5.5
Stable tag: 3.2.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Calorie Calculator can be used to estimate the calories you need to consume each day. It also provides simple guidelines to gain or lose weight.

== Description ==

This Calorie Calculator is based on the Mifflin - St Jeor equation. The Calorie Calculator can be used to estimate the calories you need to consume each day. This calculator can also provide some simple guideline if you want to gain or lose weight. 
The best way to lose weight is through proper diet and exercise. Try not to lower your calorie intake by more than 1,000 calories per day, and try to lower your calorie intake gradually. Also, try to maintain your level of fiber intake and balance your other nutritional needs. The results of the Calorie Calculator are based on an estimated average.

= How to Use =

1. From your widget setting select "Calorie Calculator" and put it in your expected sidebar.
2. Select an unit. By default it shows both "US Unit" and "Metric Unit". But you can show only "US Unit" or "Metric Unit".
3. You can select a template (I recommend to keep the default option - General) from General, Twitter Bootstrap General, Old/Classic.
4. You can show Name Field, Email Fields, etc to shave user details in the Backend as Calorie Calculator Logs.

= Pro Version Usage =

Calorie Calculator Pro comes with a handful of super useful features including flexible shortcode, download as PDF, Send to email, Automatic Mailchimp Subsciption, Strong Calculator Logging, Table of calories in food, Calorie burning by exercies and many more. Also, I provide premium support for my premium customer. [Buy Pro or See full list of features here.](https://zubaer.com/wordpress/calorie-calculator-pro/ "Calorie Calculator Pro List of Features")

4. If you want do to enable "Send Calculator Result as Email" and "Download Result as PDF" option, you can select them.
5. If you want to show "Calorie in Common Foods" table and "Calorie Burning by Common exercises", you can select them. (Your website sidebar should be wide enough to display these tables. Consider enabling it only if this widget is put in a wider place like footer widget or something else.)

= Using Shortcodes: =

1. General shortcode with default styling and all options enabled is `[calorie_calculator]`
2. If you want to show this widget inside of php codes or within your theme you can use `<?php echo do_shortcode( '[calorie_calculator]' ); ?>`
3. All attributes calorie_calculator shortcode supports are:
    
    i) send_to_email="false/true" (default value is 'true')
    ii) download_as_pdf="false/true" (default value is 'true')
    iii) unit="usunit/metricunit/both" (default value is 'both')
    iv) template="general/bootstrap-general/old" (default value is 'general')
    v)  show_name_field="true/false" (default value is 'true'. This field is required for Mailchimp subscription)
    vi) show_email_field="true/false" (default value is 'true'. This field is required for Mailchimp subscription)
    vii) show_firstname_only="true/false" (default value is 'false')

    Example: `[calorie_calculator send_to_email="false" download_as_pdf="false" template="general"]`

    Note: If you don't include an attribute within the shortcode, default value will be applied for that. As an example: send_to_email isn't included with value false in the shortcode example above. So, it will be displayed.

5. To make things easier, there is a shortcode generator included in the "Calorie Calculator" *Settings page.*


= Saving Calculator Data to the Database =

1. Calculator usage details and user data gets stored in the Database automatically. You can to the 'Calorie Calculator Logs' page to those data.


= Subscribing User to Your Mailchimp List =
1. You can subscribe users to a Mailchimp List.
2. For this you need to go to 'Mailchimp' tab of the 'Calorie Calculator' Settings page from WordPress Dashboard.
3. Then Enter you Mailchimp API Secret Key and Mailchimp List ID. You can get help from the links there.
4. You must have 'Show Name' and 'Show Email' field enabled (in widgets/shortcodes) for Mailchimp Subscription to work.


= Import/Export: =

You can easily export all foods and calorie burning activities/exercises table data by clicking on "Export Foods as CSV" and "Export Activities as CSV" button. On the otherhand, you can import them easily by selecting respective files and then clicking on "Import Foos" and "Import Activiites" button within "Calorie Calculator" *Settings page.*   


= Adding new Foods and Activites: =

Within "Calorie Calculator" setting page you will find two tabs named as "Calorie in Foods" and "Calorie Burning by Exercises" where you can easily add a new food or exercise, update them and delete them.


== Installation ==

1. Click on "Install Now" and then "Activate" the plugin.
2. You will find a new widget named "Calorie Calculator" at the "Appearence" >> "Widget" page.
3. Place the widget wherever you want and you are done.

Manual Installation:

1. Download the plugin as a Zip file.
2. Go you "Plugins" >> "Add New" from your Website's Dashboard.
3. Click on "Upload" and upload the downloaded file.
4. Click on the "Activate" button when it's uploaded.
5. The next steps are same as the automatic installation.


== Frequently Asked Questions ==

= What is Calorie Calculator? =

Calorie Calculator allows you show a Widget at your website\'s sidebar to allow your users to estimate the calories they need to consume each day.

= On Which basis Calorie Calculator is calculating this values? =

Calorie Calculator is based on the Mifflin - St Jeor equation. With this equation, the Basal Metabolic Rate (BMR) is calculated.

== Screenshots ==

1. Calorie Calculator US Units
2. Calorie Calculator Metric Units
3. Calorie Calculator US Units Filled Up
4. Calorie Calculator Result
5. Calorie Calculator New User Interfaces
6. Calorie Calculator Widget
7. Calorie Calculator Logs
8. Calorie Calculator Old/Classic Template
9. Calorie Calculator Result Only


= Pro Version Features = 

10. Body fat percentage support.
11. Pro Version Shortcode Result.
12. Pro Version Send to Email and Download as PDF
13. Pro Version Result Download as PDF
14. Pro Version Shortcode Generator.
15. Pro Version Import/Export Foods and Exercises.
16. Pro Version Foods Management in the Backend
17. Pro Version Foods Table
18. Pro Version Exercises Table.
19. Send Email Notification containing user data when someone uses the calculator.
20. Option to save user details in the user's Browser (Local Storage) so that they don't have to input ages, height, weight, etc. again and again.

== Changelog ==

= 3.2.8 =
* CSS bug fixes

= 3.2.7 =
* RTL Language support

= 3.2.6 =
* Bug fixes
* Performance Improvements.

= 3.2.5 =
* Bug fixes
* Performance Improvements.

= 3.2.4 =
* Bug fixes
* Performance Improvements.

= 3.2.3 =
* Made setting Calculator Easier.
* Visual Improvements.

= 3.2.2 =
* Added helpful message and updated compatibility.

= 3.2.1 =
* Issue with Firefox browser is now fixed.
* Bug fixes and enhancements.

= 3.2.0 =
* Bug fixes and enhancements

= 3.1.9 =
* Weight field tooltip issue fixed.

= 3.1.8 =
* CSS Issue fixation.

= 3.1.7 =
* Bootstrap Style Not Showing issue fixed.

= 3.1.6 =
* CSS Overflow issue with Select Activity option Fixed.

= 3.1.5 =
* CSS Enhancement

= 3.1.4 =
* Bug Fixes and CSS Enhancement

= 3.1.3 =
* Bug Fixes and Improved user experience

= 3.1.0 =
* Bug fixes and improved user experience

= 3.0.1 =
* Bug fix with Calorie Calculator Logs

= 3.0.0 =
* Attractive and Imporved User Interface
* Save user details as Calculator Logs
* User Name and User Email Field.
* Use Calculator Logs and User Details as you wish
* Made Faster and Secure.

= 2.5.0 =
* Working with the latest version of wordpress 4.8

= 2.5.0 =
* Performance improvement
* Security improvement
* Ready to upgrade

= 2.0.2 = 
* Frontend template and bootstrap template issue fixation

= 2.0.1 =
* Bootstrap template showing issue fixation.

= 2.0.0 =
* Support for Twitter Bootstrap. Now, you can enable "Twitter Bootstrap" specific styling if your theme supports twitter bootstrap.
* Performance improvement.

= 1.1.0 =
* Switch for showing 'US Units' or 'Metric Units' or both added.
* Plugin has been made compitable for translation.

= 1.0.0 =
* First version of Calorie Calculator.

== Upgrade Notice ==

= 2.0.2 = 
* Frontend template and bootstrap template issue fixation

= 2.0.1 =
* Bootstrap template showing issue fixation

= 2.0.0 =
* Support for Twitter Bootstrap. Now, you can enable "Twitter Bootstrap" specific styling if your theme supports twitter bootstrap.
* Performance improvement.

= 1.1.0 =
* You can now show only 'US Units' or 'Metric Units' or both added.
* Plugin has been made compitable for translation.