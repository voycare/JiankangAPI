<?php

use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('faqs')->delete();
        
        \DB::table('faqs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'question' => 'Which women’s health care specialties do you offer consultations for?',
                'answer' => '-	We currently offer online consultations for women’s mental health and fertility.',
                'type' => 1,
                'created_at' => '2020-04-17 04:49:42',
                'updated_at' => '2020-04-17 04:49:42',
            ),
            1 => 
            array (
                'id' => 3,
                'question' => 'Do health providers speak Chinese?',
                'answer' => '-	All China based health providers speak Mandarin Chinese. In the case of international health providers, some may speak Chinese. It is not a requirement for a health provider to speak Chinese during an online consultation service. Voycare provides consecutive interpretation services.',
                'type' => 1,
                'created_at' => '2020-04-17 04:50:39',
                'updated_at' => '2020-04-17 04:50:39',
            ),
            2 => 
            array (
                'id' => 4,
                'question' => 'I do not like video calls, can I do my consultation via audio call only?',
                'answer' => '-	Yes, you have an option to participate in your consultation via audio or video call.',
                'type' => 1,
                'created_at' => '2020-04-17 04:51:12',
                'updated_at' => '2020-04-17 04:51:12',
            ),
            3 => 
            array (
                'id' => 5,
                'question' => 'Is Chinese interpretation included in the price of the consultation?',
                'answer' => '-	No, this is a separate add-on service.',
                'type' => 1,
                'created_at' => '2020-04-17 04:51:45',
                'updated_at' => '2020-04-17 04:51:45',
            ),
            4 => 
            array (
                'id' => 6,
                'question' => 'Is there a limit on the number of consultations I can have?',
                'answer' => '-	No, you can book unlimited number of consultations with as many health providers as you need.',
                'type' => 1,
                'created_at' => '2020-04-17 04:52:05',
                'updated_at' => '2020-04-17 04:52:05',
            ),
            5 => 
            array (
                'id' => 7,
                'question' => 'What type of consultations are available on your platform?',
                'answer' => '-	We offer online consultations, which allow you to have an audio or video call with a health provide.  You can also book a site visit appointment if a physical appointment is preferred.  ',
                'type' => 1,
                'created_at' => '2020-04-17 04:52:29',
                'updated_at' => '2020-04-17 04:52:29',
            ),
            6 => 
            array (
                'id' => 9,
                'question' => 'How long are online consultations?',
                'answer' => '-	Online consultations start at 30 minutes and increase in 15-minute intervals.',
                'type' => 1,
                'created_at' => '2020-04-17 04:53:22',
                'updated_at' => '2020-04-17 04:53:22',
            ),
            7 => 
            array (
                'id' => 10,
                'question' => 'I don’t see a specific region or clinic I am interested in.  Can you still help me?',
                'answer' => '-	We may.  Please contact our Provider support team to let us know about the region you wish to find a doctor in.',
                'type' => 1,
                'created_at' => '2020-04-17 04:53:44',
                'updated_at' => '2020-04-17 04:53:44',
            ),
            8 => 
            array (
                'id' => 11,
                'question' => 'Can I go visit the clinic or doctor in person after my online consultation?',
                'answer' => '-	Yes, you can.  In fact, it may be needed after your first online consultation.  Simply book your site visit appointment and we’ll help you prepare any necessary paper work prior to your visit.',
                'type' => 1,
                'created_at' => '2020-04-17 04:54:15',
                'updated_at' => '2020-04-17 04:54:15',
            ),
            9 => 
            array (
                'id' => 12,
                'question' => 'Why should I join Voycare?',
                'answer' => '-	You love what you do, which is helping people heal or become healthier.  Now you want to bring your passion to the Chinese market.',
                'type' => 2,
                'created_at' => '2020-04-17 04:55:25',
                'updated_at' => '2020-04-17 04:55:25',
            ),
            10 => 
            array (
                'id' => 13,
                'question' => 'Is it free to join Voycare?',
                'answer' => '-	Yes, it’s absolutely free to sign up and start using Voycare. You only pay a fee for services rendered when making an appointment with a health provider.',
                'type' => 2,
                'created_at' => '2020-04-17 04:55:57',
                'updated_at' => '2020-04-17 04:55:57',
            ),
            11 => 
            array (
                'id' => 14,
                'question' => 'Is Voycare only limited to telemedicine or can I physically see my patient?',
                'answer' => '-	Both, you can use the Voycare for remote online consultations or to set up an appointment for a physical site visit.',
                'type' => 2,
                'created_at' => '2020-04-17 04:56:22',
                'updated_at' => '2020-04-17 04:56:22',
            ),
            12 => 
            array (
                'id' => 15,
                'question' => 'What specialties are you accepting providers for?',
                'answer' => '-	Currently, our specialties include mental health counseling and fertility for women.',
                'type' => 2,
                'created_at' => '2020-04-17 04:56:45',
                'updated_at' => '2020-04-17 04:56:45',
            ),
            13 => 
            array (
                'id' => 16,
                'question' => 'How much money can I make using the platform for each of my sessions?',
                'answer' => '-	It’s entirely up to you.  You are in control of how much you charge for online consultations and any treatment resulting an initial consultation.',
                'type' => 2,
                'created_at' => '2020-04-17 04:57:06',
                'updated_at' => '2020-04-17 04:57:06',
            ),
            14 => 
            array (
                'id' => 17,
                'question' => 'How do you pay health providers?',
                'answer' => '-	Net 30 days for all online consultation sales minus wire transfer processing fees and commission fee.',
                'type' => 2,
                'created_at' => '2020-04-17 04:57:33',
                'updated_at' => '2020-04-17 04:57:33',
            ),
            15 => 
            array (
                'id' => 18,
                'question' => 'Do I need to speak the language of the patient in order to use Voycare?',
                'answer' => '-	No, but in most cases your patient will be a Chinese speaker. In the event you cannot speak Mandarin Chinese, a Voycare appointed consecutive interpreter will be joining the online consultation to assist.',
                'type' => 2,
                'created_at' => '2020-04-17 04:57:56',
                'updated_at' => '2020-04-17 04:57:56',
            ),
            16 => 
            array (
                'id' => 19,
                'question' => 'Do you offer region exclusivity?',
                'answer' => '-	No, there is no exclusivity given to any health provider.',
                'type' => 2,
                'created_at' => '2020-04-17 04:58:17',
                'updated_at' => '2020-04-17 04:58:17',
            ),
            17 => 
            array (
                'id' => 20,
                'question' => 'How do I join Voycare?',
                'answer' => '-	Go to our Join Provider page ',
                'type' => 2,
                'created_at' => '2020-04-17 04:58:59',
                'updated_at' => '2020-04-17 04:58:59',
            ),
            18 => 
            array (
                'id' => 21,
                'question' => 'Do you provide travel bookings and travel visa services?',
                'answer' => '-	Yes, we have a travel division that can help with your travel needs when you choose to travel for treatments.',
                'type' => 3,
                'created_at' => '2020-04-17 04:59:34',
                'updated_at' => '2020-04-17 04:59:34',
            ),
            19 => 
            array (
                'id' => 22,
                'question' => 'Do you provide local ground support in the destination of a health provider?',
                'answer' => '-	Yes, we can help coordinate local travel support once you have reached your medical destination of choice.  ',
                'type' => 3,
                'created_at' => '2020-04-17 05:00:28',
                'updated_at' => '2020-04-17 05:00:28',
            ),
            20 => 
            array (
                'id' => 23,
                'question' => 'Do you offer VIP travel services?',
                'answer' => '-	Yes, we do.  Our travel specialists can coordinate all VIP travel arrangements for your medical destination of choice.  ',
                'type' => 3,
                'created_at' => '2020-04-17 05:00:51',
                'updated_at' => '2020-04-17 05:00:51',
            ),
            21 => 
            array (
                'id' => 24,
                'question' => 'Is travel included in the treatment packages by clinic?',
                'answer' => '-	No.  All treatment pricing is exclusive of any travel expensive.',
                'type' => 3,
                'created_at' => '2020-04-17 05:01:14',
                'updated_at' => '2020-04-17 05:01:14',
            ),
            22 => 
            array (
                'id' => 25,
                'question' => 'What type of accommodations do you offer in the destination of the clinic?',
                'answer' => '-	Typically, we offer clients a minimum  of 4-star international hotel accommodations or luxury apartment rentals.  Please discuss with our travel specialists for options.',
                'type' => 3,
                'created_at' => '2020-04-17 05:03:04',
                'updated_at' => '2020-04-17 05:03:04',
            ),
            23 => 
            array (
                'id' => 26,
                'question' => 'Do you offer local Chinese speaking guides?',
                'answer' => '-	Yes, our travel specialists will be able to find local Chinese speaking guides at your medical destination.',
                'type' => 3,
                'created_at' => '2020-04-17 05:08:00',
                'updated_at' => '2020-04-17 05:08:00',
            ),
            24 => 
            array (
                'id' => 27,
                'question' => 'How much are the consultations?',
                'answer' => '-	Prices varies depending on the health provider.',
                'type' => 4,
                'created_at' => '2020-04-17 05:08:30',
                'updated_at' => '2020-04-17 05:08:30',
            ),
            25 => 
            array (
                'id' => 28,
                'question' => 'Can I pay in RMB for a consultation or treatment?',
                'answer' => '-	Yes, you can pay in RMB by paying with Wechat Pay, AliPay or China UnionPay.',
                'type' => 4,
                'created_at' => '2020-04-17 05:08:57',
                'updated_at' => '2020-04-17 05:08:57',
            ),
            26 => 
            array (
                'id' => 29,
                'question' => 'I had a poor connection during my consultation and was unable to speak with the clinic or doctor.  Will I receive a refund?',
                'answer' => '-	Yes, in the event you were unable to successfully have your online consultation due to a technical glitch, you will be eligible for a refund, minus any payment processing fees.  Please contact our support team for more information.',
                'type' => 4,
                'created_at' => '2020-04-17 05:09:20',
                'updated_at' => '2020-04-17 05:09:20',
            ),
            27 => 
            array (
                'id' => 30,
                'question' => 'I forgot to attend my consultation call and did not notify Voycare. Can I still qualify for refund or reschedule?',
                'answer' => '-	No, you will not receive a refund for failure to show up for your online consultation without a 48-hour advance.  Make sure you check your notifications for appointment reminders.',
                'type' => 4,
                'created_at' => '2020-04-17 05:09:48',
                'updated_at' => '2020-04-17 05:09:48',
            ),
            28 => 
            array (
                'id' => 31,
                'question' => 'I was unable to attend a consultation call due to an emergency.  Can I receive a refund or have the ability to reschedule the call?',
                'answer' => '-	In the event of an emergency out of your control, please contact support to help you reschedule or issue a refund.  Please keep in mind, additional documentation may be requested to prove your emergency. ',
                'type' => 4,
                'created_at' => '2020-04-17 05:10:09',
                'updated_at' => '2020-04-17 05:10:09',
            ),
            29 => 
            array (
                'id' => 32,
                'question' => 'What payment options to you offer?',
                'answer' => '-	We accept all major credit cards as well as Wechat Pay, AliPay and China UnionPay.',
                'type' => 4,
                'created_at' => '2020-04-17 05:10:38',
                'updated_at' => '2020-04-17 05:10:38',
            ),
            30 => 
            array (
                'id' => 33,
                'question' => 'Do you offer bulk discounts, subscriptions or student discounts?',
                'answer' => '-	Currently we do not, but may introduce in the future.  Follow us on WeChat to keep abreast of new products and services we may introduce in the future.',
                'type' => 4,
                'created_at' => '2020-04-17 05:10:59',
                'updated_at' => '2020-04-17 05:10:59',
            ),
            31 => 
            array (
                'id' => 34,
                'question' => 'Do you have an app?',
                'answer' => '-	Currently we do not have a native mobile app. Our web platform is mobile friendly and can be accessed from a smart phone mobile device or tablet.',
                'type' => 5,
                'created_at' => '2020-04-17 05:11:30',
                'updated_at' => '2020-04-17 05:11:30',
            ),
            32 => 
            array (
                'id' => 35,
                'question' => 'I was not happy with my consultation, what should I do?',
                'answer' => '-	Contact our support team with your concerns to better assist you.',
                'type' => 5,
                'created_at' => '2020-04-17 05:12:01',
                'updated_at' => '2020-04-17 05:12:01',
            ),
            33 => 
            array (
                'id' => 36,
                'question' => 'Does your platform work on smart phones and tablet?',
                'answer' => '-	Yes, our web platform is mobile friendly.',
                'type' => 5,
                'created_at' => '2020-04-17 05:12:23',
                'updated_at' => '2020-04-17 05:12:23',
            ),
            34 => 
            array (
                'id' => 37,
                'question' => 'Do I need to be on a WiFi device to use the platform?',
                'answer' => '-	Yes, but more importantly you need an internet connection.  You can use our platform through WiFi connection or through your phone carrier data plan.',
                'type' => 5,
                'created_at' => '2020-04-17 05:13:17',
                'updated_at' => '2020-04-17 05:13:17',
            ),
            35 => 
            array (
                'id' => 38,
                'question' => 'I was given a refund or credit, but I do not see it on my account.  What should I do?',
                'answer' => '-	You will need to contact our support team to help you look into your refund request.  Don’t worry, if a refund was approved your funds will be returned minus any processing fees.',
                'type' => 5,
                'created_at' => '2020-04-17 05:13:45',
                'updated_at' => '2020-04-17 05:13:45',
            ),
            36 => 
            array (
                'id' => 39,
                'question' => 'I would like to offer your services to my employees as a benefit.  Do you have an employer benefits package?',
                'answer' => '-	At the moment we do not, but may introduce one in the near future.',
                'type' => 5,
                'created_at' => '2020-04-17 05:14:06',
                'updated_at' => '2020-04-17 05:14:06',
            ),
            37 => 
            array (
                'id' => 40,
                'question' => 'What is the best way to reach customer service?',
                'answer' => '-	You can send us an email at support@voycare.com',
                'type' => 5,
                'created_at' => '2020-04-17 05:14:27',
                'updated_at' => '2020-04-17 05:14:27',
            ),
        ));
        
        
    }
}