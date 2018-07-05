module.exports = {
  "status": "wip",
  "name": "Content Page",
  "variants": [
    {
      "name": "default",
      "label": "Email Us",
      "notes": "https://www.usa.gov/email",
      "context": {
            "tid": "10980",
            "name": "Email USA.gov",
            "description": null,
            "format": "filtered_html",
            "weight": "5",
            "changed": "1520483873",
            "uuid": "85a6db7f-6039-4baf-93fe-8dfd224ac5d4",
            "vocabulary_machine_name": "site_strucutre_taxonomy",
            "path": "1",
            "type": "taxonomy_term",
            "deleted": null,
            "parent_uuid": "d0146b6e-35b2-4554-954e-6c7af981678a",
            "parent": "10978",
            "children": [],
            "govdelivery_id": null,
            "page_intro": "Email us your questions about the U.S. government or your comments about our website, USA.gov.",
            "head_html": "<link rel=\"canonical\" href=\"https:\/\/www.usa.gov\/email\" \/>\r\n<script type = \"text\/javascript\"> \r\n\t$(document).ready(function() {\r\n\t\tfunction validateEmail(email) {\r\n\t\t\tvar re = \/\\S+@\\S+\\.\\S+\/; \/\/This is a very simple regex for email\r\n\t\t\treturn re.test(email);\r\n\t\t}\r\n\t\t$('.validate').submit(function() {\r\n\t\t\tvar noerrors = true;\r\n\t\t\t$('.required').each(function() {\r\n\t\t\t\tif ($(this).find('input,textarea').val() == \"\") {\r\n\t\t\t\t\tnoerrors = false;\r\n\t\t\t\t\tif (!($(this).find('p.err-label').length)) {\r\n\t\t\t\t\t\tvar error = $(this).find('input,textarea').attr('data-error');\r\n\t\t\t\t\t\t$(this).find('label').after('<p class=\"err-label\">' + error + '<\/p>');\r\n\t\t\t\t\t}\r\n\t\t\t\t} else if (($(this).find('input').attr('id') == 'email' && !validateEmail($(this).find('input#email').val()))) {\r\n\t\t\t\t\tnoerrors = false;\r\n\t\t\t\t\tif (!($(this).find('p.err-label').length)) {\r\n\t\t\t\t\t\tvar error = $(this).find('input,textarea').attr('data-error');\r\n\t\t\t\t\t\t$(this).find('label').after('<p class=\"err-label\">' + error + '<\/p>');\r\n\t\t\t\t\t}\r\n\t\t\t\t} else if ($(this).find('p.err-label').length) {\r\n\t\t\t\t\t$(this).find('p.err-label').remove();\r\n\t\t\t\t}\r\n\t\t\t});\r\n\t\t\tif (!noerrors) window.scrollTo(0, 0);\r\n\t\t\treturn noerrors;\r\n\t\t});\r\n\t}); \r\n<\/script>\r\n<script src=\"https:\/\/www.google.com\/recaptcha\/api.js\"><\/script>\r\n<script>\r\n function timestamp() { var response = document.getElementById(\"g-recaptcha-response\"); if (response == null || response.value.trim() == \"\") {var elems = JSON.parse(document.getElementsByName(\"captcha_settings\")[0].value);elems[\"ts\"] = JSON.stringify(new Date().getTime());document.getElementsByName(\"captcha_settings\")[0].value = JSON.stringify(elems); } } setInterval(timestamp, 500); \r\n<\/script>\r\n<script>\r\n\tvar submitPressed = function() {\r\n\t\tif (grecaptcha.getResponse().length === 0) {\r\n\t\t\tif ($('.err-label-captcha').length < 1) {\r\n\t\t\t\t$('.g-recaptcha').before('<p class=\"err-label err-label-captcha\">Please fill out the reCaptcha<\/p>');\r\n\t\t\t}\r\n\t\t\treturn false;\r\n\t\t} else {\r\n\t\t\t$('.err-label-captcha').remove();\r\n\t\t}\r\n\t\treturn true;\r\n\t}; \r\n<\/script>",
            "end_html": "<script type=\"text\/javascript\">\r\njQuery(document).ready( function () {\r\n$('#cntctbx').hide();\r\n});\r\n<\/script>",
            "generate_page": "yes",
            "also_include_on_nav_page": [],
            "asset_topic_taxonomy": [
                {
                    "tid": "10983",
                    "uuid": "00f42192-d01f-49b1-a222-959b8e29f03f",
                    "type": "taxonomy_term",
                    "bundle": "asset_topic_taxonomy"
                }
            ],
            "page_title": "Email USA.gov to Find Government Information and Services",
            "usefulness_survey": "0",
            "browser_title": "Email Us",
            "friendly_url": "\/email",
            "usa_gov_toggle_url": null,
            "gobiernousa_gov_toggle_url": "\/email",
            "type_of_page_to_generate": "generic-content-page",
            "asset_inherit_carousel": "0",
            "asset_inherit_content": "0",
            "asset_inherit_sidebar": "0",
            "asset_inherit_bottom": "0",
            "asset_order_carousel": [],
            "asset_order_content": [
                {
                    "target_id": "206103",
                    "uuid": "bdf9dd03-0773-41bb-95e8-22e100a95a66",
                    "type": "node",
                    "bundle": "html_content_type"
                }
            ],
            "asset_order_sidebar": [],
            "asset_order_bottom": [],
            "asset_inherit_menu": "0",
            "asset_order_menu": null,
            "generate_menu": "yes",
            "css_class": null,
            "usa_gov_50_state_category": null,
            "directory_record_access_me": null,
            "directory_record_url": null,
            "home_alert_asset": null,
            "show_social_media_icon": null,
            "term_owner": null,
            "help_desk": null,
            "usa_gov_50_state_prefix": null,
            "home_howdoi_assets": [],
            "home_whats_new_asset": [],
            "government_branch": null,
            "real_meta_description": "USA.gov\u2019s email service can help you find information on federal agencies, programs, benefits, services, and more.",
            "description_meta": "USA.gov\u2019s email service can help you find information on federal agencies, programs, benefits, services, and more.",
            "for_use_by": "USA.gov",
            "pageType": "GenericContentPage",
            "menu": [],
            "child_pages": [],
            "parent_menu": [
                {
                    "uuid": "4b2764d8-eee4-4aaf-bd16-526def1b50aa",
                    "name": "Call USA.gov",
                    "friendly_url": "\/phone",
                    "css_class": null,
                    "description_meta": "USA.gov\u2019s information specialists can help you find information on federal agencies, programs, benefits, services, and more.",
                    "sub": []
                },
                {
                    "uuid": "f5bda1eb-e12e-4f43-bff0-ee5472719cb0",
                    "name": "Chat with USA.gov",
                    "friendly_url": "\/chat",
                    "css_class": null,
                    "description_meta": "USA.gov\u2019s live chat service can help you find information on federal agencies, programs, benefits, services, and more.",
                    "sub": []
                },
                {
                    "uuid": "85a6db7f-6039-4baf-93fe-8dfd224ac5d4",
                    "name": "Email USA.gov",
                    "friendly_url": "\/email",
                    "css_class": null,
                    "description_meta": "USA.gov\u2019s email service can help you find information on federal agencies, programs, benefits, services, and more.",
                    "sub": []
                },
                {
                    "uuid": "270bedd9-22ee-45d9-bf0b-bc3cc2591ec2",
                    "name": "Find What You Need with USA.gov",
                    "friendly_url": "\/how-to-use",
                    "css_class": null,
                    "description_meta": "Find out the ways to look for official government information on the website USA.gov.",
                    "sub": []
                }
            ],
            "entities": {
              "bdf9dd03-0773-41bb-95e8-22e100a95a66":{
                    "title": "Email Submission Form for USA.gov",
                    "log": "Edited by bryant.jones@gsa.gov.",
                    "status": "1",
                    "sticky": null,
                    "vuuid": "6a18b555-6c20-4690-9626-c6caa2a2b63d",
                    "nid": "206103",
                    "type": "html_content_type",
                    "language": "English",
                    "created": "1428607827",
                    "changed": "1520437784",
                    "tnid": null,
                    "translate": null,
                    "uuid": "bdf9dd03-0773-41bb-95e8-22e100a95a66",
                    "name": "david.kaufmann@gsa.gov",
                    "deleted": null,
                    "comments": null,
                    "description": "This asset contains the code for the form to send an email to the website USA.gov.",
                    "for_use_by": "USA.gov",
                    "html": "<p>Email us your questions about the U.S. government or your comments about our website, USA.gov. We will respond to your questions in English or Spanish.<\/p>\r\n\r\n<p><strong>Do you want to send a message to an elected official, such as the President?<\/strong> We can't forward emails to elected officials, so please contact them directly:<\/p>\r\n\t\t<ul class=\"emailqstn\">\r\n\t\t\t<li><a href=\"https:\/\/www.whitehouse.gov\/contact\/\">President of the United States<\/a><\/li>\r\n\t\t\t<li><a href=\"\/elected-officials\">Members of the U.S. Congress and more<\/a><\/li>\t\r\n\t\t<\/ul>\t\t\r\n\t\r\n\t<p>If we can't answer your question directly, our response will:<\/p>\r\n\t\t<ul class=\"emailqstn\">\r\n\t\t\t<li>Refer you to the government agency that can help.<\/li>\r\n\t\t\t<li>Help you locate the information you need. Additional research on your part may be required to get your exact answer.<\/li>\r\n\t\t<\/ul>\r\n\t\t\t\t\t \t\t\t\r\n\t<p>If your question is very complex or specific, we may be able to provide you with more personalized service if you call us at 1-844-USA-GOV1 (<a href=\"tel:18448724681\">1-844-872-4681<\/a>).\r\n\t    We're available Monday to Friday 8 AM to 8 PM Eastern Time.<\/p>\r\n\r\n\t<p>To help us serve you better, please include:<\/p>\t\t\t\r\n\t\t<ul class=\"emailqstn\">\r\n\t\t\t<li>Any resources you have already tried.<\/li>\r\n\t\t\t<li>The program or agency you are asking about, if you know.<\/li>\r\n\t\t<\/ul>\r\n\t\r\n\t<p>For your protection, do not include personal information like telephone or Social Security numbers.<\/p> \r\n<div id=\"emlfnd\">\r\n<form action=\"https:\/\/webto.salesforce.com\/servlet\/servlet.WebToCase?encoding=UTF-8\" class=\"validate\" id=\"myform\" method=\"post\" name=\"myform\">\r\n              <input type=hidden name='captcha_settings' value='{\"keyname\":\"Recaptcha_FCIC\",\"fallback\":\"true\",\"orgId\":\"00DU0000000Leux\",\"ts\":\"\"}'>\r\n              <input name=\"orgid\" type=\"hidden\" value=\"00DU0000000Leux\">\r\n              <input name=\"retURL\" type=\"hidden\" value=\"http:\/\/usa.gov\/thank-you-email\">\r\n             <input id=\"recordType\" name=\"recordType\" type=\"hidden\" value=\"012U00000001eYv\">\r\n              <input name=\"Sender_IP__c\" type=\"hidden\" value=\"192.168.1.1\">\r\n              <input name=\"Site_Version__c\" type=\"hidden\" value=\"New\">\r\n              <div class=\"usa-alert usa-alert-info\">\r\n                <div class=\"usa-alert-body\">\r\n                  <p class=\"usa-alert-heading\">All fields marked with an asterisk (*) are required fields. <\/p>\r\n                  <p class=\"usa-alert-text\">If you have any issues with the reCAPTCHA, please call <a href=\"tel:18448724681\">1-844-872-4681<\/a>.<\/p>\r\n                <\/div>\r\n              <\/div>\r\n              <p class=\"required\">\r\n                <label for=\"00NU0000004z90C\">* First Name:<\/label>\r\n                <input aria-required=\"true\" data-error=\"Please enter your first name\" data-name=\"First Name\" id=\"00NU0000004z90C\" maxlength=\"255\" name=\"00NU0000004z90C\" size=\"40\" type=\"text\">\r\n              <\/p>\r\n              <p class=\"required\">\r\n                <label for=\"email\">* Email Address:<\/label>\r\n                <input aria-required=\"true\" data-error=\"Please enter a valid e-mail address\" data-name=\"Email Address\" id=\"email\" maxlength=\"80\" name=\"email\" size=\"40\" type=\"email\">\r\n              <\/p>\r\n              <p>\r\n                <label for=\"00NU0000004z91C\">ZIP Code:<\/label>\r\n                <input id=\"00NU0000004z91C\" maxlength=\"10\" name=\"00NU0000004z91C\" size=\"20\" type=\"text\">\r\n\r\n              <\/p>\r\n\r\n              <p class=\"required\">\r\n\r\n                <label for=\"description\" class=\"dscrptn\">* Enter Question Here:<br>\r\n\r\n                  Please limit your question to 1000 characters.<\/label>\r\n\r\n              <textarea aria-required=\"true\" type=\"text\" id=\"description\" cols=\"40\" rows=\"10\" maxlength=\"1000\" name=\"description\" data-name=\"Description\" data-error=\"Please enter a comment\"><\/textarea><\/p>\r\n\r\n\r\n                <div style=\"visibility: hidden; z-index: 2;\" class=\"_e725ae-textarea_btn _e725ae-anonymous _e725ae-not_focused\" data-grammarly-reactid=\".0\">\r\n\r\n                  <div class=\"_e725ae-transform_wrap\" data-grammarly-reactid=\".0.0\">\r\n\r\n                    <div title=\"Protected by Grammarly\" class=\"_e725ae-status\" data-grammarly-reactid=\".0.0.0\">&nbsp;<\/div>\r\n\r\n                  <\/div>\r\n\r\n                  <span class=\"_e725ae-btn_text\" data-grammarly-reactid=\".0.1\">Not signed in<\/span><\/div>\r\n\r\n\r\n              <input type=\"hidden\" id=\"external\" name=\"external\" value=\"1\">\r\n\r\n\r\n              <div class=\"g-recaptcha\" title=\"reCAPCHA\" data-sitekey=\"6LdFORIUAAAAAIgJPQBlcE7hEMMuRf8T6Vlfp_xb\"><\/div>\r\n\r\n              <p style=\"display: none;visibility:hidden\" class=\"extrainfo\">\r\n\r\n                <label for=\"00Nt0000000FsTK\">Please ignore this box.<\/label>\r\n\r\n                <input id=\"00Nt0000000FsTK\" maxlength=\"255\" name=\"00Nt0000000FsTK\" size=\"20\" type=\"text\">\r\n\r\n              <\/p>\r\n\r\n              <p>\r\n\r\n                <input type=\"submit\" name=\"submit\" value=\"Submit\" onclick=\"return submitPressed();\">\r\n\r\n              <\/p>\r\n<\/form>\t<\/div>\t\t\r\n<p class=\"clearfix\"><\/p>",
                    "notify_marketing_team": "No",
                    "priority": "normal",
                    "schedule_publish": null,
                    "archive_date": null,
                    "date_last_reviewed": null,
                    "content_tags": null,
                    "asset_topic_taxonomy": [
                        {
                            "tid": "10983",
                            "uuid": "00f42192-d01f-49b1-a222-959b8e29f03f",
                            "type": "taxonomy_term",
                            "bundle": "asset_topic_taxonomy"
                        }
                    ],
                    "workflow_state_search": "published",
                    "blog_pub_date": null,
                    "blog_owner": null,
                    "gob_feature_toggle_url": null,
                    "usa_feature_toggle_url": null,
                    "pageType": null
              }
            }
      }
    },
    {
    "name": "Retirement",
    "notes": "https://www.usa.gov/retirement",
    "context": {
        "tid": "10782",
        "name": "Retirement",
        "description": null,
        "format": null,
        "weight": "4",
        "changed": "1523384004",
        "whats_new": [
            {
              "uuid": "21c2d005-7730-41c0-9798-ee5f132168ee",
              "title": "Recognize The Signs of Suicide and Find Help"
            },
            {
              "uuid": "c1ed09ba-f19f-4908-bf71-4086f0045fcc",
              "title": "Preventing Addiction: Share Your Story"
            }
          ],
        "uuid": "4ededc48-1926-4f19-9eba-a49ce82eb700",
        "vocabulary_machine_name": "site_strucutre_taxonomy",
        "path": "1",
        "type": "taxonomy_term",
        "deleted": null,
        "parent_uuid": "3e0f00f4-81f9-4de7-a786-4a783b36d3f9",
        "parent": "10772",
        "children": [],
        "govdelivery_id": null,
        "page_intro": "Get the basics on retirement planning and pension benefits, such as how Social Security works, retiring from the civil service, and managing a private pension.\r\n",
        "head_html": null,
        "end_html": null,
        "generate_page": "yes",
        "also_include_on_nav_page": [],
        "asset_topic_taxonomy": [
            {
                "tid": "981",
                "uuid": "c4ff7aff-ec32-4805-92ef-c237193a635b",
                "type": "taxonomy_term",
                "bundle": "asset_topic_taxonomy"
            }
        ],
        "page_title": "Retirement",
        "usefulness_survey": "0",
        "browser_title": "Retirement",
        "friendly_url": "\/retirement",
        "usa_gov_toggle_url": null,
        "gobiernousa_gov_toggle_url": "\/jubilacion",
        "type_of_page_to_generate": "generic-content-page",
        "asset_inherit_carousel": "0",
        "asset_inherit_content": "0",
        "asset_inherit_sidebar": "0",
        "asset_inherit_bottom": "0",
        "asset_order_carousel": [],
        "asset_order_content": [
            {
                "target_id": "212761",
                "uuid": "fe54e31f-54da-4893-9b07-5431706e14b8",
                "type": "node",
                "bundle": "multimedia_content_type",
            },
            {
                "target_id": "212808",
                "uuid": "faa3be04-cb5b-46a1-b60b-cc6c02eed018",
                "type": "node",
                "bundle": "multimedia_content_type"
            },
            {
                "target_id": "212313",
                "uuid": "9540ef41-35da-4b80-89c2-ef1dad7979a0",
                "type": "node",
                "bundle": "text_content_type"
            },
            {
                "target_id": "37502",
                "uuid": "de360a7e-14f9-4656-8037-0ba1adfce65a",
                "type": "node",
                "bundle": "text_content_type"
            },
            {
                "target_id": "36427",
                "uuid": "021aab4f-0cc9-4c1c-b4b6-cfcbd72f44f8",
                "type": "node",
                "bundle": "text_content_type"
            },
            {
                "tid": "213876",
                "uuid": "3bdf55da-8822-446e-9d86-f3b2605ad3de",
                "type": "taxonomy_term",
                "bundle": "asset_topic_taxonomy"
            },
            {
                "tid": "213875",
                "uuid": "00d8f85f-745a-427f-9052-e30c98f952e7",
                "type": "taxonomy_term",
                "bundle": "asset_topic_taxonomy"
            }
        ],
        "asset_order_sidebar": [],
        "asset_order_bottom": [],
        "asset_inherit_menu": "0",
        "asset_order_menu": null,
        "generate_menu": "yes",
        "css_class": null,
        "usa_gov_50_state_category": null,
        "directory_record_access_me": null,
        "directory_record_url": null,
        "home_alert_asset": null,
        "show_social_media_icon": null,
        "term_owner": null,
        "help_desk": null,
        "usa_gov_50_state_prefix": null,
        "home_howdoi_assets": [],
        "home_whats_new_asset": [],
        "government_branch": null,
        "real_meta_description": "Get the basics on retirement planning and pension benefits, such as how Social Security works, retiring from the civil service, and managing a private pension.\r\n",
        "description_meta": "Learn some of the basics about retirement and pension benefits.",
        "for_use_by": "USA.gov",
        "pageType": "GenericContentPage",
        "menu": [],
        "child_pages": [],
        "parent_menu": [
            {
                "uuid": "c4d4e3fe-912d-49b6-abfe-730d0b6350a4",
                "name": "Labor Laws and Issues",
                "friendly_url": "\/labor-laws",
                "css_class": null,
                "description_meta": "Learn about some important employment laws and issues.",
                "sub": []
            },
            {
                "uuid": "848b4e15-152d-4d49-8f8d-18ce3e4839f8",
                "name": "Looking for a New Job",
                "friendly_url": "\/job-search",
                "css_class": null,
                "description_meta": "Find out how to look for work in the private sector and federal government.",
                "sub": []
            },
            {
                "uuid": "f4c057bb-47c7-45cc-a213-c13b5bed691d",
                "name": "Public Service and Volunteer Opportunities",
                "friendly_url": "\/volunteer",
                "css_class": null,
                "description_meta": "Find a volunteer opportunity that suits you and help the environment, local communities, veterans and more.",
                "sub": []
            },
            {
                "uuid": "90bd4ffe-5fe1-4c86-8ebd-57b6d32b35ab",
                "name": "Research Career Fields",
                "friendly_url": "\/jobs-careers",
                "css_class": null,
                "description_meta": "Find research information and videos to learn about different career fields. Learn more about other jobs at the Occupational Outlook Handbook.",
                "sub": []
            },
            {
                "uuid": "4ededc48-1926-4f19-9eba-a49ce82eb700",
                "name": "Retirement",
                "friendly_url": "\/retirement",
                "css_class": null,
                "description_meta": "Learn some of the basics about retirement and pension benefits.",
                "sub": []
            },
            {
                "uuid": "58ebca9d-d224-481a-a392-8966720c465c",
                "name": "Small Business",
                "friendly_url": "\/business",
                "css_class": "busa",
                "description_meta": "Learn the steps to start a small business, get financing help from the government, and more.",
                "sub": []
            },
            {
                "uuid": "f5d4a3fd-5b9e-4a14-990f-22a4564dc4ca",
                "name": "U.S. Government Employees",
                "friendly_url": "\/federal-employees",
                "css_class": null,
                "description_meta": "Learn where to get the answers to some of the questions asked most often by federal workers.",
                "sub": []
            },
            {
                "uuid": "1fee5ee3-4dad-4f8f-bfb2-9a760184f79b",
                "name": "Unemployment Benefits and Other Help for the Unemployed",
                "friendly_url": "\/unemployment",
                "css_class": null,
                "description_meta": "Discover some of the programs and resources that can help if you lose your job.",
                "sub": []
            }

          ],
          "entities":{
            "3e0f00f4-81f9-4de7-a786-4a783b36d3f9": {
                "name": "Jobs and Unemployment",
                "friendly_url": "\/jobs-and-unemployment",
                "menu": [
                    {
                        "uuid": "c4d4e3fe-912d-49b6-abfe-730d0b6350a4",
                        "name": "Labor Laws and Issues",
                        "friendly_url": "\/labor-laws",
                        "css_class": null,
                        "description_meta": "Learn about some important employment laws and issues.",
                        "sub": []
                    },
                    {
                        "uuid": "848b4e15-152d-4d49-8f8d-18ce3e4839f8",
                        "name": "Looking for a New Job",
                        "friendly_url": "\/job-search",
                        "css_class": null,
                        "description_meta": "Find out how to look for work in the private sector and federal government.",
                        "sub": []
                    },
                    {
                        "uuid": "f4c057bb-47c7-45cc-a213-c13b5bed691d",
                        "name": "Public Service and Volunteer Opportunities",
                        "friendly_url": "\/volunteer",
                        "css_class": null,
                        "description_meta": "Find a volunteer opportunity that suits you and help the environment, local communities, veterans and more.",
                        "sub": []
                    },
                    {
                        "uuid": "90bd4ffe-5fe1-4c86-8ebd-57b6d32b35ab",
                        "name": "Research Career Fields",
                        "friendly_url": "\/jobs-careers",
                        "css_class": null,
                        "description_meta": "Find research information and videos to learn about different career fields. Learn more about other jobs at the Occupational Outlook Handbook.",
                        "sub": []
                    },
                    {
                        "uuid": "4ededc48-1926-4f19-9eba-a49ce82eb700",
                        "name": "Retirement",
                        "friendly_url": "\/retirement",
                        "css_class": null,
                        "description_meta": "Learn some of the basics about retirement and pension benefits.",
                        "sub": []
                    },
                    {
                        "uuid": "58ebca9d-d224-481a-a392-8966720c465c",
                        "name": "Small Business",
                        "friendly_url": "\/business",
                        "css_class": "busa",
                        "description_meta": "Learn the steps to start a small business, get financing help from the government, and more.",
                        "sub": []
                    },
                    {
                        "uuid": "f5d4a3fd-5b9e-4a14-990f-22a4564dc4ca",
                        "name": "U.S. Government Employees",
                        "friendly_url": "\/federal-employees",
                        "css_class": null,
                        "description_meta": "Learn where to get the answers to some of the questions asked most often by federal workers.",
                        "sub": []
                    },
                    {
                        "uuid": "1fee5ee3-4dad-4f8f-bfb2-9a760184f79b",
                        "name": "Unemployment Benefits and Other Help for the Unemployed",
                        "friendly_url": "\/unemployment",
                        "css_class": null,
                        "description_meta": "Discover some of the programs and resources that can help if you lose your job.",
                        "sub": []
                    }
                ]
          },
          "44c33ecc-f0e4-4a70-a2f3-10f9facbe044": {
              "title": "Bouquets and Bruises: This Valentine\u2019s Day, Help Someone Experiencing Abuse",
              "log": "Edited by andrea.castelluccio@gsa.gov.",
              "status": "1",
              "sticky": null,
              "vuuid": "7d42beea-b8bf-4260-9720-374668b93f82",
              "nid": "213383",
              "type": "text_content_type",
              "language": "English",
              "created": "1486673053",
              "changed": "1517931699",
              "tnid": null,
              "translate": null,
              "uuid": "44c33ecc-f0e4-4a70-a2f3-10f9facbe044",
              "body": "<p>The greeting card aisle crams with shoppers, struggling to find the right sentiment. Buyers line up at the register with heart-shaped boxes of chocolate and keep florists busy juggling orders for beautiful bouquets. It&rsquo;s all part of the excitement and romance of Valentine&rsquo;s Day. But for someone who&rsquo;s recovering from sexual assault or living with domestic violence, all of the cards and roses in the world can&rsquo;t make up for the pain.<\/p><p>If you want to support a friend in this difficult situation, or if you need support yourself, <a href=\"https:\/\/www.usa.gov\/explore\/\">USAGov<\/a> has gathered these resources to help:<\/p><h3>When your friend needs you<\/h3><p>&ldquo;You really don&rsquo;t know unless you&rsquo;ve been there.&rdquo; From the outside, it can be hard to understand why people hesitate to report a sexual assault or <a href=\"http:\/\/www.womenshealth.gov\/violence-against-women\/types-of-violence\/domestic-intimate-partner-violence.html#g\">stay in abusive relationships<\/a>. But there are a lot of reasons: fear that no one would believe them--especially if the attacker is respected in the community; concern for their own or their children&rsquo;s safety; financial instability; or feeling--because of the abuser&rsquo;s mind games--that they deserve the abuse. Learn how to help your friend move toward safety and healing with these <a href=\"http:\/\/womenshealth.gov\/violence-against-women\/get-help-for-violence\/how-to-help-a-friend-who-is-being-abused.html\">suggestions from WomensHealth.gov<\/a>.<\/p><h3>When you&rsquo;re a bystander<\/h3><p>If you&rsquo;re a college student, you might have heard about sexual assaults on your campus. Some of those assaults may have been prevented if bystanders had spoken up. The <a href=\"http:\/\/www.itsonus.org\/\">It&rsquo;s On Us<\/a> campaign works to prevent sexual assault by changing the college culture. Get <a href=\"http:\/\/www.itsonus.org\/tools\/\">tips and tools<\/a> to teach you to trust that knot in your stomach when something doesn&rsquo;t seem right and <a href=\"https:\/\/www.womenshealth.gov\/violence-against-women\/help-end-violence-against-women\/index.html\">take action<\/a> to help end violence against women.<\/p><h3>When you&rsquo;re the one who&rsquo;s hurting<\/h3><p>Living through <a href=\"https:\/\/www.girlshealth.gov\/safety\/saferelationships\/daterape.html\">rape<\/a> or domestic violence can be isolating and shocking, and it can leave you wrapped in shame and hopelessness. Your partner may try to convince you that you&rsquo;re not really being abused, or that it&rsquo;s your fault. This list of <a href=\"http:\/\/womenshealth.gov\/violence-against-women\/am-i-being-abused\/index.html\">signs of abuse<\/a> can help you evaluate what you&rsquo;re experiencing.<\/p><p>Even if you&rsquo;re not ready to make a report to the police, you can still begin <a href=\"http:\/\/www.womenshealth.gov\/violence-against-women\/get-help-for-violence\/safety-planning-for-abusive-situations.html\">creating a safety plan<\/a> to leave a dangerous situation. And you can reach out for non-judgmental support anonymously, day or night, from the <a href=\"http:\/\/www.thehotline.org\/help\/\">National Domestic Violence Hotline<\/a> at <a href=\"tel:18007997233\">1-800-799-7233<\/a>. You can also contact the <a href=\"https:\/\/rainn.org\/get-help\/national-sexual-assault-hotline\">National Sexual Assault Hotline<\/a> at <a href=\"tel:18006564673\">1-800-656-HOPE<\/a> (4673). If possible, contact them from a phone or computer account that your abuser can&rsquo;t access so they won&rsquo;t be able to trace your call records or browsing history.<\/p><p>These organizations are ready to refer you to local help for counseling; treatment for stress, depression, or trauma; and housing and child care programs. With them, and with supportive friends and family, you won&rsquo;t have to be alone during this difficult time.<\/p><p>The government is filled with programs and services that can help make life a little easier and safer for you and your family. Let USAGov be your guide at <a href=\"https:\/\/www.usa.gov\/explore\/\">USA.gov\/explore<\/a>.<\/p><p><a href=\"https:\/\/gobierno.usa.gov\/novedades\/rosas-y-espinas-en-este-dia-de-san-valentin,-digale-no-al-abuso\">En espa\u00f1ol<\/a>.<\/p>",
              "name": "andrea.castelluccio@gsa.gov",
              "deleted": null,
              "comments": null,
              "description": "If you want to support a friend in this difficult situation, or if you need support yourself, USAGov has gathered these resources to help.",
              "notify_marketing_team": "No",
              "contact_center_info": null,
              "for_use_by_text": [
                  "USA.gov",
                  "Feature"
              ],
              "schedule_publish": null,
              "archive_date": null,
              "date_last_reviewed": null,
              "content_tags": null,
              "asset_topic_taxonomy": [
                  {
                      "tid": "11098",
                      "uuid": "916901b3-0032-47cf-b785-d1864c0562fa",
                      "type": "taxonomy_term",
                      "bundle": "asset_topic_taxonomy"
                  }
              ],
              "related_multimedia_two": {
                  "target_id": "212507",
                  "uuid": "64445c0c-55a6-4bd8-a724-ad325374305e",
                  "type": "node",
                  "bundle": "multimedia_content_type"
              },
              "priority": "normal",
              "workflow_state_search": "draft",
              "blog_owner": null,
              "blog_pub_date": "1486673056",
              "usa_feature_toggle_url": "\/features\/this-valentines-day-help-someone-experiencing-abuse",
              "gob_feature_toggle_url": null,
              "for_use_by": [
                  "USA.gov",
                  "Feature"
              ],
              "pageType": null
          },
          "64445c0c-55a6-4bd8-a724-ad325374305e": {
              "title": "Bouquets and Roses English",
              "log": "Edited by julia.sultan@gsa.gov.",
              "status": "1",
              "sticky": null,
              "vuuid": "2ab6ea7b-d4e9-4c0c-96ac-26b3a6f552ba",
              "nid": "212507",
              "type": "multimedia_content_type",
              "language": "English",
              "created": "1455028955",
              "changed": "1517952256",
              "tnid": null,
              "translate": null,
              "uuid": "64445c0c-55a6-4bd8-a724-ad325374305e",
              "name": "edgardo.morales@gsa.gov",
              "deleted": null,
              "alt_text": "A flower on the ground. ",
              "comments": null,
              "description": "Image for feature. ",
              "embed_code": null,
              "for_use_by": "USA.gov",
              "media_type": "Image",
              "notify_marketing_team": "No",
              "transcript": null,
              "schedule_publish": null,
              "archive_date": null,
              "date_last_reviewed": null,
              "content_tags": null,
              "asset_topic_taxonomy": [],
              "url": null,
              "high_res_version": null,
              "widget_code": null,
              "priority": "normal",
              "info_for_contact_center": null,
              "workflow_state_search": null,
              "file_media": {
                  "fid": "d8d02a49-90b2-40a8-a807-796afc308fd2",
                  "uid": "afc1e1c6-348b-433b-b81b-1ee5a882c4dd",
                  "filename": "Bouquets and Roses.jpg",
                  "uri": "\/\/app_usa_prod_eqffnyamdzrb.s3.amazonaws.com\/Bouquets and Roses_0.jpg",
                  "filemime": "image\/jpeg",
                  "filesize": "46372",
                  "status": "1",
                  "timestamp": "1455028934",
                  "type": "image",
                  "uuid": "d8d02a49-90b2-40a8-a807-796afc308fd2",
                  "field_file_image_alt_text": [],
                  "field_file_image_title_text": [],
                  "_drafty_revision_requested": "FIELD_LOAD_CURRENT",
                  "rdf_mapping": [],
                  "metadata": {
                      "height": 558,
                      "width": 600
                  },
                  "height": "558",
                  "width": "600",
                  "alt": null,
                  "title": null
              },
              "pageType": null
          },
          "670f5340-fae1-4513-83d2-cd37f3aa8e10": {
              "tid": "11715",
              "vid": "42",
              "name": "Mental Health and Substance Abuse",
              "description": null,
              "format": "filtered_html",
              "weight": "2",
              "changed": "1520484380",
              "uuid": "670f5340-fae1-4513-83d2-cd37f3aa8e10",
              "vocabulary_machine_name": "site_strucutre_taxonomy",
              "path": "1",
              "type": "taxonomy_term",
              "deleted": null,
              "parent_uuid": "cb1ebfcc-edfd-4bbd-a1d8-4e1d22a1da61",
              "parent": "10702",
              "children": [],
              "govdelivery_id": null,
              "page_intro": "Find mental health services, including treatment for drug and alcohol addiction.",
              "head_html": null,
              "end_html": null,
              "generate_page": "yes",
              "also_include_on_nav_page": [],
              "asset_topic_taxonomy": [
                  {
                      "tid": "11714",
                      "uuid": "889fc605-b6a4-4c79-856b-1c25066eee96",
                      "type": "taxonomy_term",
                      "bundle": "asset_topic_taxonomy"
                  }
              ],
              "page_title": "Mental Health and Substance Abuse",
              "usefulness_survey": "0",
              "browser_title": "Mental Health and Substance Abuse",
              "friendly_url": "\/mental-health-substance-abuse",
              "usa_gov_toggle_url": null,
              "gobiernousa_gov_toggle_url": "\/salud-mental-y-abuso-de-sustancias",
              "type_of_page_to_generate": "generic-content-page",
              "asset_inherit_carousel": "0",
              "asset_inherit_content": "0",
              "asset_inherit_sidebar": "0",
              "asset_inherit_bottom": "0",
              "asset_order_carousel": [],
              "asset_order_content": [
                  {
                      "target_id": "35207",
                      "uuid": "00e88c74-d9eb-4686-b943-0474ce6272b3",
                      "type": "node",
                      "bundle": "text_content_type"
                  },
                  {
                      "target_id": "35032",
                      "uuid": "3f29a841-8a7b-417d-adf4-0f5ec428cf1a",
                      "type": "node",
                      "bundle": "text_content_type"
                  },
                  {
                      "target_id": "212301",
                      "uuid": "f69da7e7-5e5d-4da1-a169-bb404027d173",
                      "type": "node",
                      "bundle": "text_content_type"
                  }
              ],
              "asset_order_sidebar": [],
              "asset_order_bottom": [],
              "asset_inherit_menu": "0",
              "asset_order_menu": null,
              "generate_menu": "yes",
              "css_class": null,
              "usa_gov_50_state_category": null,
              "directory_record_access_me": null,
              "directory_record_url": null,
              "home_alert_asset": null,
              "show_social_media_icon": "No",
              "term_owner": null,
              "help_desk": {
                  "tid": "11441",
                  "uuid": "e5e04fee-031b-48cd-ab6c-d5552ce364d3",
                  "type": "taxonomy_term",
                  "bundle": "topic_desk_assignment"
              },
              "usa_gov_50_state_prefix": null,
              "home_howdoi_assets": [],
              "home_whats_new_asset": [],
              "government_branch": null,
              "real_meta_description": "Find mental health services, including treatment for drug and alcohol addiction.",
              "description_meta": "Find mental health services, including treatment for drug and alcohol addiction.",
              "for_use_by": [
                  "USA.gov"
              ],
              "pageType": "GenericContentPage",
              "whats_new":
                {
                  "uuid": "21c2d005-7730-41c0-9798-ee5f132168ee",
                  "title": "Recognize The Signs of Suicide and Find Help"
                },
              "menu": [],
              "child_pages": []
          },
          "21c2d005-7730-41c0-9798-ee5f132168ee": {
              "title": "Recognize The Signs of Suicide and Find Help ",
              "log": "Edited by joanne.mcgovern@gsa.gov.",
              "status": "1",
              "sticky": null,
              "vuuid": "4f005af5-b78b-4ceb-8aa9-d64e75b86ce7",
              "nid": "214031",
              "type": "text_content_type",
              "language": "English",
              "created": "1528403341",
              "changed": "1528982530",
              "tnid": null,
              "translate": null,
              "uuid": "21c2d005-7730-41c0-9798-ee5f132168ee",
              "body": "<p>Suicide is the second leading cause of death in people between the ages of 15 to 34 in the United States, according to a new study from the <a href=\"https:\/\/www.cdc.gov\/vitalsigns\/suicide\/\">Centers for Disease Control (CDC). <\/a>The report revealed an increase in suicides in nearly every state from 1999 through 2016. Suicide is a serious public health issue that affects families and communities across the nation.<\/p><p>Its causes can be complex and involve many factors, from mental illness and abuse, to social isolation and depression, but relationship problems and substance misuse are also frequent reasons.<\/p><h3><strong>Immediate Help<\/strong><\/h3><p>If you or someone you know needs help, contact the <a href=\"https:\/\/suicidepreventionlifeline.org\/\">National Suicide Prevention Lifeline<\/a> at 1 800-273-TALK (<a href=\"18002738255\">1-800-273-8255<\/a>) or <a href=\"http:\/\/chat.suicidepreventionlifeline.org\/GetHelp\/LifelineChat.aspx?_ga=2.206975445.737297435.1513612528-439458455.1512567911\">through chat<\/a> available 24\/7. You can also text a professional for help with the <a href=\"https:\/\/www.crisistextline.org\/\">Crisis Text Line at 741741<\/a>.<\/p><p>If you believe someone is in immediate danger, do not leave the person alone and call 911. Know and share these resources--it could save a life.<\/p><p><a href=\"https:\/\/suicidepreventionlifeline.org\/help-yourself\/en-espanol\/\">Find help 24\/7 in Spanish<\/a> at <a href=\"18886289454\">1-888-628-9454<\/a>.<\/p><h3><strong>Be Aware; Listen<\/strong><\/h3><p>Every 13 minutes, someone commits suicide in the U.S. There are ways to identify signs and make an approach if you suspect a friend or loved one is considering suicide<\/p><ul><li><p>Learn to <a href=\"http:\/\/www.mentalhealth.gov\/what-to-look-for\/suicidal-behavior\/index.html\">recognize the signs<\/a> and what you can do as a parent, sibling, other relative, friend, or even acquaintance to help.<\/p><\/li><li>Be familiar with the <a href=\"https:\/\/suicidepreventionlifeline.org\/how-we-can-all-prevent-suicide\/\">risk factors of suicide<\/a>.<\/li><li>Know the <a href=\"https:\/\/www.nimh.nih.gov\/health\/topics\/suicide-prevention\/index.shtml#part_153220\">five action steps<\/a> for helping someone in emotional pain.<\/li><\/ul><h3><strong>Service Members and Veterans<\/strong><\/h3><ul><li>Veterans and their loved ones can call <a href=\"18002738255\">1-800-273-8255<\/a> and Press 1, <a href=\"https:\/\/www.veteranscrisisline.net\/ChatTermsOfService.aspx\">chat online<\/a>, or send a text message to 838255 to receive confidential support.<\/li><li><a href=\"https:\/\/www.veteranscrisisline.net\/\">Find support<\/a> and help for military members before, during, or after service. &nbsp;<\/li><li>Take the <a href=\"https:\/\/www.vetselfcheck.org\/Welcome.cfm\">Self-Check Quiz<\/a> to learn whether stress and depression might be affecting you.<\/li><\/ul>",
              "name": "edgardo.morales@gsa.gov",
              "deleted": null,
              "comments": "June 11, 2018 fixed broken link for five action steps under H3 Be aware. sa ",
              "description": "Suicide is the second leading cause of death in people between the ages of 15 to 34 in the United States, according to a new study from the Centers for Disease Control (CDC). ",
              "notify_marketing_team": "No",
              "contact_center_info": null,
              "for_use_by": [
                  "USA.gov",
                  "Feature"
              ],
              "schedule_publish": null,
              "archive_date": null,
              "date_last_reviewed": null,
              "content_tags": null,
              "asset_topic_taxonomy": [
                  {
                      "tid": "11726",
                      "uuid": "81b5336e-8c53-45e5-8d39-67da44802cce",
                      "type": "taxonomy_term",
                      "bundle": "asset_topic_taxonomy"
                  },
                  {
                      "tid": "11714",
                      "uuid": "889fc605-b6a4-4c79-856b-1c25066eee96",
                      "type": "taxonomy_term",
                      "bundle": "asset_topic_taxonomy"
                  },
                  {
                      "tid": "11098",
                      "uuid": "916901b3-0032-47cf-b785-d1864c0562fa",
                      "type": "taxonomy_term",
                      "bundle": "asset_topic_taxonomy"
                  }
              ],
              "related_multimedia_two": {
                  "target_id": "213799",
                  "uuid": "37653ce3-d858-4808-956b-6622cc133a64",
                  "type": "node",
                  "bundle": "multimedia_content_type"
              },
              "priority": "normal",
              "workflow_state_search": null,
              "blog_owner": null,
              "blog_pub_date": "1528403342",
              "usa_feature_toggle_url": null,
              "gob_feature_toggle_url": "\/novedades\/conozca-las-senales-de-advertencia-del-suicidio-y-encuentre-apoyo",
              "pageType": null,
              "shares_topic": [
                  {
                      "uuid": "689a061b-4ca3-4621-ab5c-944e74b1fae1",
                      "title": "Navigating Power of Attorney: How to Help Loved Ones Manage Their Money",
                      "changed": "1528132766",
                      "created": "1441031609"
                  },
                  {
                      "uuid": "33f53727-c9ce-4d70-a6b8-2bca342729c0",
                      "title": "Nine Money Tips for Building Your American Dream",
                      "changed": "1476376202",
                      "created": "1444322359"
                  },
                  {
                      "uuid": "95ba8096-718e-4d47-a1f3-5a750778603f",
                      "title": "Living with Diabetes: Say Yes to Good Health!",
                      "changed": "1478970302",
                      "created": "1447181053"
                  },
                  {
                      "uuid": "381ce38a-e62e-439d-8ffa-bbf9b799da82",
                      "title": "Ask Marietta: How Do I Keep My Credit Card Info Safe While Online Shopping?",
                      "changed": "1479481226",
                      "created": "1447790265"
                  },
                  {
                      "uuid": "0447a63e-06f8-4822-9101-419f50bc8b36",
                      "title": "November Is National Native American Heritage Month",
                      "changed": "1507729458",
                      "created": "1448366936"
                  },
                  {
                      "uuid": "2cd4b9e2-6fb5-4e5b-a389-974b4072d86f",
                      "title": " Losing Weight: Getting Started",
                      "changed": "1509129883",
                      "created": "1453747013"
                  },
                  {
                      "uuid": "dd51dc00-e0f4-4877-8d1d-1600cae53321",
                      "title": "Bouquets and Bruises: This Valentine\u2019s Day, Help Someone Experiencing Abuse",
                      "changed": "1494536175",
                      "created": "1455030267"
                  },
                  {
                      "uuid": "432cf648-560c-4de2-b0cb-c1f003ab8208",
                      "title": "Zika Virus - What You Need to Know",
                      "changed": "1509130112",
                      "created": "1455228545"
                  },
                  {
                      "uuid": "930600af-f0ea-4888-8064-68ca64fa6fb5",
                      "title": "Clinical trials: Seeking Diversity in Women for Better Testing",
                      "changed": "1515531277",
                      "created": "1462197416"
                  },
                  {
                      "uuid": "ecb22e1c-0cfe-4e58-a9fa-29890e0a1d67",
                      "title": "USAGov\u2019s Five Tips to Get Great Deals from Government Auctions and Sales",
                      "changed": "1517865920",
                      "created": "1462822706"
                  },
                  {
                      "uuid": "faa2d73d-0889-46bc-8f35-9b51369427a5",
                      "title": "Support for Families When A Suicide Attempt Hits Home",
                      "changed": "1512170304",
                      "created": "1464103779"
                  },
                  {
                      "uuid": "aebd760b-23a0-4ea2-8e47-8772a7de0395",
                      "title": "Critical Rx For a Healthy Home",
                      "changed": "1521231460",
                      "created": "1464111159"
                  },
                  {
                      "uuid": "461e04cb-f293-4b27-bf69-3ca7eeb982a4",
                      "title": "USAGov\u2019s Guide to Displaying the American Flag",
                      "changed": "1515699823",
                      "created": "1467133461"
                  },
                  {
                      "uuid": "44c33ecc-f0e4-4a70-a2f3-10f9facbe044",
                      "title": "Bouquets and Bruises: This Valentine\u2019s Day, Help Someone Experiencing Abuse",
                      "changed": "1517931699",
                      "created": "1486673053"
                  },
                  {
                      "uuid": "c26dead7-438c-4567-80f8-c659e984e1fd",
                      "title": "Free, Official Sources to Find Unclaimed Money",
                      "changed": "1513181598",
                      "created": "1487782834"
                  },
                  {
                      "uuid": "0297cf56-155b-40b6-a982-abe6b180cb21",
                      "title": "Four Reasons Not to Put Off Signing up for a \u201cmy Social Security\u201d Account",
                      "changed": "1492191896",
                      "created": "1492013206"
                  },
                  {
                      "uuid": "de5ebb0a-66c2-4d41-bb61-2ae0b2cfe31e",
                      "title": "USAGov\u2019s Guide for Seniors",
                      "changed": "1513115271",
                      "created": "1494617647"
                  },
                  {
                      "uuid": "16e5bf3c-5a65-47bd-9423-7e62909df334",
                      "title": "Order Your Free Copy of the 2017 Consumer Action Handbook",
                      "changed": "1522896807",
                      "created": "1500061809"
                  },
                  {
                      "uuid": "121271a2-acaf-4277-9377-9782417939b5",
                      "title": "Leaving the Military? Avoid Job and Education Scams",
                      "changed": "1513871505",
                      "created": "1500314035"
                  },
                  {
                      "uuid": "ae35af19-33c1-4351-8bc2-bc9e741b2cd8",
                      "title": "USAGov\u2019s Back to School Guide for Teachers and Parents  ",
                      "changed": "1506352998",
                      "created": "1502215837"
                  },
                  {
                      "uuid": "0a48cec2-4ba8-44c0-a52a-21a2c86e1964",
                      "title": "One Easy Place to Find Proof of Your Social Security Benefits",
                      "changed": "1515163264",
                      "created": "1506962342"
                  },
                  {
                      "uuid": "a8ca8804-ef1c-455d-be51-a937debe73ca",
                      "title": "Three Passport Life Hacks To Try Before 2018",
                      "changed": "1515163235",
                      "created": "1507659826"
                  },
                  {
                      "uuid": "24095ca5-7bae-40ae-b52a-7469af65cc24",
                      "title": "Preparation for Tomorrow Begins Today",
                      "changed": "1512676047",
                      "created": "1509473988"
                  },
                  {
                      "uuid": "fe91f32a-c84b-4211-a339-3e3253c713b9",
                      "title": "This Is Just a Drill",
                      "changed": "1517863553",
                      "created": "1509646280"
                  },
                  {
                      "uuid": "2d7e0a7e-b853-49a2-973e-03b884d62e5f",
                      "title": "How to Fight Flu This Season ",
                      "changed": "1515163192",
                      "created": "1509982442"
                  },
                  {
                      "uuid": "f7ce08c9-64b2-45b0-be21-0150efdf8181",
                      "title": " USAGov\u2019s Guide to Holiday Shopping",
                      "changed": "1511181510",
                      "created": "1510782997"
                  },
                  {
                      "uuid": "deed6b90-c3f8-4fc6-a170-ddbcbe4e48e5",
                      "title": "Five New Year\u2019s Resolutions that USAGov Can Help You Achieve",
                      "changed": "1515789384",
                      "created": "1513342834"
                  },
                  {
                      "uuid": "75c81385-1bb0-4912-9d23-7f12deb13bc4",
                      "title": "USAGov\u2019s Apps to Download in 2018",
                      "changed": "1528739085",
                      "created": "1513966020"
                  },
                  {
                      "uuid": "ee77187e-4996-46f8-9c83-2dc5418f04d1",
                      "title": "Kids and Depression",
                      "changed": "1517864439",
                      "created": "1516116107"
                  },
                  {
                      "uuid": "e4f9a27b-550d-4964-bffd-8f7d128c61c3",
                      "title": "This Valentine\u2019s Day Help Someone Experiencing Abuse",
                      "changed": "1527168681",
                      "created": "1517928103"
                  },
                  {
                      "uuid": "1c6aac6d-46c6-42c8-8285-6e84b8148704",
                      "title": "Protect Yourself and Your Money Every Day",
                      "changed": "1527168652",
                      "created": "1519655119"
                  },
                  {
                      "uuid": "b97f6062-b766-4099-a34b-cad1e1c76796",
                      "title": "A Healthy Prescription For a Healthy Home",
                      "changed": "1521232890",
                      "created": "1521231018"
                  },
                  {
                      "uuid": "b97f6062-b766-4099-a34b-cad1e1c76796",
                      "title": "A Healthy Prescription For a Healthy Home",
                      "changed": "1521232890",
                      "created": "1521231018"
                  },
                  {
                      "uuid": "b1f838cc-f7e5-43ce-8cc9-aaf73485fe64",
                      "title": "A Healthy Prescription For a Healthy Home",
                      "changed": "1527168575",
                      "created": "1521231018"
                  },
                  {
                      "uuid": "c1ed09ba-f19f-4908-bf71-4086f0045fcc",
                      "title": "Preventing Addiction: Share Your Story",
                      "changed": "1527168539",
                      "created": "1524770091"
                  },
                  {
                      "uuid": "c1ed09ba-f19f-4908-bf71-4086f0045fcc",
                      "title": "Preventing Addiction: Share Your Story",
                      "changed": "1527168539",
                      "created": "1524770091"
                  },
                  {
                      "uuid": "112c4fa0-0cea-473a-b858-d04d13991e7b",
                      "title": "USAGov\u2019s 6 Things to Know Before You Start Paying Off Your Student Loans",
                      "changed": "1529349100",
                      "created": "1526395378"
                  },
                  {
                      "uuid": "c4026a63-35f6-4830-8906-f134aca8c90c",
                      "title": "Get Help with Living Expenses",
                      "changed": "1528406135",
                      "created": "1527108456"
                  },
                  {
                      "uuid": "21c2d005-7730-41c0-9798-ee5f132168ee",
                      "title": "Recognize The Signs of Suicide and Find Help ",
                      "changed": "1528982530",
                      "created": "1528403341"
                  },
                  {
                      "uuid": "21c2d005-7730-41c0-9798-ee5f132168ee",
                      "title": "Recognize The Signs of Suicide and Find Help ",
                      "changed": "1528982530",
                      "created": "1528403341"
                  },
                  {
                      "uuid": "21c2d005-7730-41c0-9798-ee5f132168ee",
                      "title": "Recognize The Signs of Suicide and Find Help ",
                      "changed": "1528982530",
                      "created": "1528403341"
                  },
                  {
                      "uuid": "ea914655-6047-423a-a238-3f321533f676",
                      "title": "USAGov's Fireworks Safety Tips for the Fourth of July",
                      "changed": "1529350903",
                      "created": "1529349032"
                  },
                  {
                      "uuid": "ea914655-6047-423a-a238-3f321533f676",
                      "title": "USAGov's Fireworks Safety Tips for the Fourth of July",
                      "changed": "1529350903",
                      "created": "1529349032"
                  }
              ]
          },
          "37653ce3-d858-4808-956b-6622cc133a64": {
              "title": "Mental Health",
              "log": "Edited by julia.sultan@gsa.gov.",
              "status": "1",
              "sticky": null,
              "vuuid": "4d626870-979c-4252-8020-4c2b82541ae0",
              "nid": "213799",
              "type": "multimedia_content_type",
              "language": "English",
              "created": "1513629128",
              "changed": "1517856519",
              "tnid": null,
              "translate": null,
              "uuid": "37653ce3-d858-4808-956b-6622cc133a64",
              "name": "edgardo.morales@gsa.gov",
              "deleted": null,
              "alt_text": "person sitting on a boardwalk",
              "comments": null,
              "description": "Depressed teenager leaning against a wall. ",
              "embed_code": null,
              "for_use_by": [
                  "USA.gov"
              ],
              "media_type": "Image",
              "notify_marketing_team": "No",
              "transcript": null,
              "schedule_publish": null,
              "archive_date": null,
              "date_last_reviewed": null,
              "content_tags": null,
              "asset_topic_taxonomy": [],
              "url": null,
              "high_res_version": null,
              "widget_code": null,
              "priority": "normal",
              "info_for_contact_center": null,
              "workflow_state_search": null,
              "file_media": {
                  "fid": "6660",
                  "uid": "1917",
                  "filename": "MentalHealth.jpg",
                  "uri": "\/\/app_usa_stg_eqffnyamdzrb.s3.amazonaws.com\/MentalHealth.jpg",
                  "filemime": "image\/jpeg",
                  "filesize": "272799",
                  "status": "1",
                  "timestamp": "1513632542",
                  "type": "image",
                  "uuid": "164dd44a-e2f7-4574-92e2-d2ba9cb4a58e",
                  "field_file_image_alt_text": [],
                  "field_file_image_title_text": [],
                  "_drafty_revision_requested": "FIELD_LOAD_CURRENT",
                  "rdf_mapping": [],
                  "metadata": {
                      "height": 1187,
                      "width": 1213
                  },
                  "height": "1187",
                  "width": "1213",
                  "alt": null,
                  "title": null
              },
              "pageType": null
          },
          "c1ed09ba-f19f-4908-bf71-4086f0045fcc": {
              "title": "Preventing Addiction: Share Your Story",
              "log": "Edited by Ashlea Blunt.",
              "status": "1",
              "sticky": null,
              "vuuid": "bd3f057c-c46a-42a5-9959-a5f367acc80e",
              "nid": "213983",
              "type": "text_content_type",
              "language": "English",
              "created": "1524770091",
              "changed": "1527168539",
              "tnid": null,
              "translate": null,
              "uuid": "c1ed09ba-f19f-4908-bf71-4086f0045fcc",
              "body": "<p>Between the endless chores, the demanding boss, and your children&rsquo;s activities, you&rsquo;re super busy and sometimes a little stressed out. It can be hard to remain strong for your family and get through the tough days without relying on alcohol or drugs to cope. The conscious choices you make now can help protect you and your family from substance abuse in the future. &nbsp;<\/p><p>During <a href=\"https:\/\/www.samhsa.gov\/prevention-week\">National Prevention Week, May 13-19<\/a>, the Substance Abuse and Mental Health Services Administration (SAMHSA) encourages families to take action today for a healthier tomorrow.<\/p><h3>Start a Discussion on Drugs With a Family Project<\/h3><p>One way to take action and begin a discussion with your kids is to create a family project. Encourage them to write letters, draw pictures, or create videos telling their future selves about the things they&rsquo;re doing now that will help them be healthier in the years to come. In turn, share stories with them of when you were younger and the lessons you learned from good or bad decisions that taught you about alcohol or drugs. <a href=\"https:\/\/www.samhsa.gov\/prevention-week\/prevention-challenge\">You and your kids can join the movement<\/a> and share your stories on social media during National Prevention Week using the hashtags #DearFutureMe and #NPW2018. As an added bonus, the letters or videos of those stories can become part of your family history to be shared with future generations.<\/p><p>By beginning the discussion today, you can help your family stay safe and make smart choices about their tomorrow.<\/p><h3>Find Help for Yourself or a Loved One<\/h3><p>If you or someone you care about is struggling with alcohol or drugs, <a href=\"https:\/\/www.usa.gov\/mental-health-substance-abuse#item-35032\">USA.gov&rsquo;s collection of hotlines and local support groups and treatment centers can help <\/a>whenever you or they are ready.<\/p>",
              "name": "edgardo.morales@gsa.gov",
              "deleted": null,
              "comments": null,
              "description": "During National Prevention Week, May 13-19, the Substance Abuse and Mental Health Services Administration (SAMHSA) encourages families to take action today for a healthier tomorrow. \r\n",
              "notify_marketing_team": "No",
              "contact_center_info": null,
              "for_use_by": [
                  "USA.gov",
                  "Feature"
              ],
              "schedule_publish": null,
              "archive_date": null,
              "date_last_reviewed": null,
              "content_tags": {
                  "tid": "271",
                  "uuid": "7ef7035c-37fb-48ec-a27e-0eec34f923bc",
                  "type": "taxonomy_term",
                  "bundle": "agency_tags"
              },
              "asset_topic_taxonomy": [
                  {
                      "tid": "11714",
                      "uuid": "889fc605-b6a4-4c79-856b-1c25066eee96",
                      "type": "taxonomy_term",
                      "bundle": "asset_topic_taxonomy"
                  },
                  {
                      "tid": "11098",
                      "uuid": "916901b3-0032-47cf-b785-d1864c0562fa",
                      "type": "taxonomy_term",
                      "bundle": "asset_topic_taxonomy"
                  }
              ],
              "related_multimedia_two": {
                  "target_id": "213987",
                  "uuid": "4b2ed85b-7910-4584-9cef-4c2fca5328ee",
                  "type": "node",
                  "bundle": "multimedia_content_type"
              },
              "priority": "normal",
              "workflow_state_search": null,
              "blog_owner": null,
              "blog_pub_date": "1524770092",
              "usa_feature_toggle_url": null,
              "gob_feature_toggle_url": "\/novedades\/sugerencias-para-prevenir-las-adicciones-en-su-familia",
              "pageType": null,
              "shares_topic": [
                  {
                      "uuid": "689a061b-4ca3-4621-ab5c-944e74b1fae1",
                      "title": "Navigating Power of Attorney: How to Help Loved Ones Manage Their Money",
                      "changed": "1528132766",
                      "created": "1441031609"
                  },
                  {
                      "uuid": "33f53727-c9ce-4d70-a6b8-2bca342729c0",
                      "title": "Nine Money Tips for Building Your American Dream",
                      "changed": "1476376202",
                      "created": "1444322359"
                  },
                  {
                      "uuid": "95ba8096-718e-4d47-a1f3-5a750778603f",
                      "title": "Living with Diabetes: Say Yes to Good Health!",
                      "changed": "1478970302",
                      "created": "1447181053"
                  },
                  {
                      "uuid": "381ce38a-e62e-439d-8ffa-bbf9b799da82",
                      "title": "Ask Marietta: How Do I Keep My Credit Card Info Safe While Online Shopping?",
                      "changed": "1479481226",
                      "created": "1447790265"
                  },
                  {
                      "uuid": "0447a63e-06f8-4822-9101-419f50bc8b36",
                      "title": "November Is National Native American Heritage Month",
                      "changed": "1507729458",
                      "created": "1448366936"
                  },
                  {
                      "uuid": "2cd4b9e2-6fb5-4e5b-a389-974b4072d86f",
                      "title": " Losing Weight: Getting Started",
                      "changed": "1509129883",
                      "created": "1453747013"
                  },
                  {
                      "uuid": "dd51dc00-e0f4-4877-8d1d-1600cae53321",
                      "title": "Bouquets and Bruises: This Valentine\u2019s Day, Help Someone Experiencing Abuse",
                      "changed": "1494536175",
                      "created": "1455030267"
                  },
                  {
                      "uuid": "432cf648-560c-4de2-b0cb-c1f003ab8208",
                      "title": "Zika Virus - What You Need to Know",
                      "changed": "1509130112",
                      "created": "1455228545"
                  },
                  {
                      "uuid": "930600af-f0ea-4888-8064-68ca64fa6fb5",
                      "title": "Clinical trials: Seeking Diversity in Women for Better Testing",
                      "changed": "1515531277",
                      "created": "1462197416"
                  },
                  {
                      "uuid": "ecb22e1c-0cfe-4e58-a9fa-29890e0a1d67",
                      "title": "USAGov\u2019s Five Tips to Get Great Deals from Government Auctions and Sales",
                      "changed": "1517865920",
                      "created": "1462822706"
                  },
                  {
                      "uuid": "faa2d73d-0889-46bc-8f35-9b51369427a5",
                      "title": "Support for Families When A Suicide Attempt Hits Home",
                      "changed": "1512170304",
                      "created": "1464103779"
                  },
                  {
                      "uuid": "aebd760b-23a0-4ea2-8e47-8772a7de0395",
                      "title": "Critical Rx For a Healthy Home",
                      "changed": "1521231460",
                      "created": "1464111159"
                  },
                  {
                      "uuid": "461e04cb-f293-4b27-bf69-3ca7eeb982a4",
                      "title": "USAGov\u2019s Guide to Displaying the American Flag",
                      "changed": "1515699823",
                      "created": "1467133461"
                  },
                  {
                      "uuid": "44c33ecc-f0e4-4a70-a2f3-10f9facbe044",
                      "title": "Bouquets and Bruises: This Valentine\u2019s Day, Help Someone Experiencing Abuse",
                      "changed": "1517931699",
                      "created": "1486673053"
                  },
                  {
                      "uuid": "c26dead7-438c-4567-80f8-c659e984e1fd",
                      "title": "Free, Official Sources to Find Unclaimed Money",
                      "changed": "1513181598",
                      "created": "1487782834"
                  },
                  {
                      "uuid": "0297cf56-155b-40b6-a982-abe6b180cb21",
                      "title": "Four Reasons Not to Put Off Signing up for a \u201cmy Social Security\u201d Account",
                      "changed": "1492191896",
                      "created": "1492013206"
                  },
                  {
                      "uuid": "de5ebb0a-66c2-4d41-bb61-2ae0b2cfe31e",
                      "title": "USAGov\u2019s Guide for Seniors",
                      "changed": "1513115271",
                      "created": "1494617647"
                  },
                  {
                      "uuid": "16e5bf3c-5a65-47bd-9423-7e62909df334",
                      "title": "Order Your Free Copy of the 2017 Consumer Action Handbook",
                      "changed": "1522896807",
                      "created": "1500061809"
                  },
                  {
                      "uuid": "121271a2-acaf-4277-9377-9782417939b5",
                      "title": "Leaving the Military? Avoid Job and Education Scams",
                      "changed": "1513871505",
                      "created": "1500314035"
                  },
                  {
                      "uuid": "ae35af19-33c1-4351-8bc2-bc9e741b2cd8",
                      "title": "USAGov\u2019s Back to School Guide for Teachers and Parents  ",
                      "changed": "1506352998",
                      "created": "1502215837"
                  },
                  {
                      "uuid": "0a48cec2-4ba8-44c0-a52a-21a2c86e1964",
                      "title": "One Easy Place to Find Proof of Your Social Security Benefits",
                      "changed": "1515163264",
                      "created": "1506962342"
                  },
                  {
                      "uuid": "a8ca8804-ef1c-455d-be51-a937debe73ca",
                      "title": "Three Passport Life Hacks To Try Before 2018",
                      "changed": "1515163235",
                      "created": "1507659826"
                  },
                  {
                      "uuid": "24095ca5-7bae-40ae-b52a-7469af65cc24",
                      "title": "Preparation for Tomorrow Begins Today",
                      "changed": "1512676047",
                      "created": "1509473988"
                  },
                  {
                      "uuid": "fe91f32a-c84b-4211-a339-3e3253c713b9",
                      "title": "This Is Just a Drill",
                      "changed": "1517863553",
                      "created": "1509646280"
                  },
                  {
                      "uuid": "2d7e0a7e-b853-49a2-973e-03b884d62e5f",
                      "title": "How to Fight Flu This Season ",
                      "changed": "1515163192",
                      "created": "1509982442"
                  },
                  {
                      "uuid": "f7ce08c9-64b2-45b0-be21-0150efdf8181",
                      "title": " USAGov\u2019s Guide to Holiday Shopping",
                      "changed": "1511181510",
                      "created": "1510782997"
                  },
                  {
                      "uuid": "deed6b90-c3f8-4fc6-a170-ddbcbe4e48e5",
                      "title": "Five New Year\u2019s Resolutions that USAGov Can Help You Achieve",
                      "changed": "1515789384",
                      "created": "1513342834"
                  },
                  {
                      "uuid": "75c81385-1bb0-4912-9d23-7f12deb13bc4",
                      "title": "USAGov\u2019s Apps to Download in 2018",
                      "changed": "1528739085",
                      "created": "1513966020"
                  },
                  {
                      "uuid": "ee77187e-4996-46f8-9c83-2dc5418f04d1",
                      "title": "Kids and Depression",
                      "changed": "1517864439",
                      "created": "1516116107"
                  },
                  {
                      "uuid": "e4f9a27b-550d-4964-bffd-8f7d128c61c3",
                      "title": "This Valentine\u2019s Day Help Someone Experiencing Abuse",
                      "changed": "1527168681",
                      "created": "1517928103"
                  },
                  {
                      "uuid": "1c6aac6d-46c6-42c8-8285-6e84b8148704",
                      "title": "Protect Yourself and Your Money Every Day",
                      "changed": "1527168652",
                      "created": "1519655119"
                  },
                  {
                      "uuid": "b97f6062-b766-4099-a34b-cad1e1c76796",
                      "title": "A Healthy Prescription For a Healthy Home",
                      "changed": "1521232890",
                      "created": "1521231018"
                  },
                  {
                      "uuid": "b1f838cc-f7e5-43ce-8cc9-aaf73485fe64",
                      "title": "A Healthy Prescription For a Healthy Home",
                      "changed": "1527168575",
                      "created": "1521231018"
                  },
                  {
                      "uuid": "c1ed09ba-f19f-4908-bf71-4086f0045fcc",
                      "title": "Preventing Addiction: Share Your Story",
                      "changed": "1527168539",
                      "created": "1524770091"
                  },
                  {
                      "uuid": "c1ed09ba-f19f-4908-bf71-4086f0045fcc",
                      "title": "Preventing Addiction: Share Your Story",
                      "changed": "1527168539",
                      "created": "1524770091"
                  },
                  {
                      "uuid": "112c4fa0-0cea-473a-b858-d04d13991e7b",
                      "title": "USAGov\u2019s 6 Things to Know Before You Start Paying Off Your Student Loans",
                      "changed": "1529349100",
                      "created": "1526395378"
                  },
                  {
                      "uuid": "c4026a63-35f6-4830-8906-f134aca8c90c",
                      "title": "Get Help with Living Expenses",
                      "changed": "1528406135",
                      "created": "1527108456"
                  },
                  {
                      "uuid": "21c2d005-7730-41c0-9798-ee5f132168ee",
                      "title": "Recognize The Signs of Suicide and Find Help ",
                      "changed": "1528982530",
                      "created": "1528403341"
                  },
                  {
                      "uuid": "21c2d005-7730-41c0-9798-ee5f132168ee",
                      "title": "Recognize The Signs of Suicide and Find Help ",
                      "changed": "1528982530",
                      "created": "1528403341"
                  },
                  {
                      "uuid": "ea914655-6047-423a-a238-3f321533f676",
                      "title": "USAGov's Fireworks Safety Tips for the Fourth of July",
                      "changed": "1529350903",
                      "created": "1529349032"
                  }
              ]
          },
          "fe54e31f-54da-4893-9b07-5431706e14b8": {
            "title": "Infographic: Common Options to Save for Retirement",
            "log": "Edited by amy.gardner@gsa.gov.",
            "status": "1",
            "sticky": null,
            "vuuid": "a861b661-935d-4615-835b-16356d5efb9e",
            "nid": "212761",
            "type": "multimedia_content_type",
            "language": "English",
            "created": "1463083548",
            "changed": "1522896894",
            "tnid": null,
            "translate": null,
            "uuid": "fe54e31f-54da-4893-9b07-5431706e14b8",
            "name": "carolyn.cihelka@gsa.gov",
            "deleted": null,
            "alt_text": "Infographic showing the ways people save for retirement in the U.S.",
            "comments": null,
            "description": "This infographic shows the most common ways people save for retirement.",
            "embed_code": null,
            "for_use_by": "USA.gov",
            "media_type": "Infographic",
            "notify_marketing_team": "No",
            "transcript": "<p>In the United States, people live an average of 20 years after retirement.&nbsp;The three most common options to save for retirement are:<\/p><ol><li>Retirement Plans offered by an employer<\/li><li>Savings and Investments<\/li><li>Social Security<\/li><\/ol><p>For more information, visit USA.gov<\/p>",
            "schedule_publish": null,
            "archive_date": null,
            "date_last_reviewed": {
                "value": "2018-01-02 17:00:00",
                "timezone": "America\/New_York",
                "timezone_db": "UTC",
                "date_type": "datetime"
            },
            "content_tags": null,
            "asset_topic_taxonomy": [
                {
                    "tid": "981",
                    "uuid": "c4ff7aff-ec32-4805-92ef-c237193a635b",
                    "type": "taxonomy_term",
                    "bundle": "asset_topic_taxonomy"
                }
            ],
            "url": null,
            "high_res_version": "https:\/\/app_usa_prod_eqffnyamdzrb.s3.amazonaws.com\/Retirement_1_Eng_R1_accessible.pdf?RKoVWnSRo7m78qNm8IRsSUhJLQKJmIqw",
            "widget_code": null,
            "priority": "normal",
            "info_for_contact_center": null,
            "workflow_state_search": null,
            "file_media": {
                "fid": "fe1241a6-2440-41d2-a480-cbf4365c6011",
                "uid": "64158c35-58e5-46f6-a0d3-1f36d22c8495",
                "filename": "Retirement Version1.jpg",
                "uri": "\/\/app_usa_prod_eqffnyamdzrb.s3.amazonaws.com\/Retirement Version1.jpg",
                "filemime": "image\/jpeg",
                "filesize": "369106",
                "status": "1",
                "timestamp": "1463083161",
                "type": "image",
                "uuid": "fe1241a6-2440-41d2-a480-cbf4365c6011",
                "field_file_image_alt_text": [],
                "field_file_image_title_text": {
                    "und": "Common Options to Save for Retirement"
                },
                "_drafty_revision_requested": "FIELD_LOAD_CURRENT",
                "rdf_mapping": [],
                "title": "Common Options to Save for Retirement",
                "metadata": {
                    "height": 1200,
                    "width": 1000
                },
                "height": "1200",
                "width": "1000",
                "alt": null
            },
            "pageType": null
          },
          "faa3be04-cb5b-46a1-b60b-cc6c02eed018": {
              "title": "Video: Determining a Target Retirement Saving Rate ",
              "log": "Edited by julia.sultan@gsa.gov.",
              "status": "1",
              "sticky": null,
              "vuuid": "281495d6-3219-44a3-81e9-dfd274f6d33a",
              "nid": "212808",
              "type": "multimedia_content_type",
              "language": "English",
              "created": "1464273973",
              "changed": "1519763837",
              "tnid": null,
              "translate": null,
              "uuid": "faa3be04-cb5b-46a1-b60b-cc6c02eed018",
              "name": "carolyn.cihelka@gsa.gov",
              "deleted": null,
              "alt_text": null,
              "comments": "I guess this has to go to the accessibility team after you, Nancy. Thanks.--Carolyn\r\n\r\n7\/27\/2016: Video disappeared so removed this embed code and replaced with new. Old: <iframe width=\"560\" height=\"315\" src=\"http:\/\/www.youtube-nocookie.com\/embed\/V-7ojClANHo?autohide=0&amp;controls=1&amp;modestbranding=1&amp;rel=0&amp;theme=light&amp;color=red&amp;cc_load_policy=1\" title=\"Determining a Target Retirement Saving Rate\" frameborder=\"0\" allowfullscreen=\"\"><a href=\"https:\/\/www.youtube.com\/embed\/V-7ojClANHo\">Watch \"Determining a Target Retirement Saving Rate\" on YouTube<\/a>.<\/iframe>",
              "description": "Make a plan with the <a href=\"http:\/\/go.usa.gov\/cJtUd\">Retirement Saving worksheet<\/a>. Learn more at <a href=\"http:\/\/go.usa.gov\/cJtP3\">Savings Fitness<\/a>.",
              "embed_code": "<iframe width=\"560\" height=\"315\" src=\"https:\/\/www.youtube-nocookie.com\/embed\/V-7ojClANHo?autohide=0&amp;controls=1&amp;modestbranding=1&amp;rel=0&amp;theme=light&amp;color=red&amp;cc_load_policy=1\" title=\"Determining a Target Retirement Saving Rate\" frameborder=\"0\" allowfullscreen=\"\"><a href=\"https:\/\/www.youtube.com\/embed\/V-7ojClANHo\">Watch \"\" on YouTube<\/a>.<\/iframe>",
              "for_use_by": "USA.gov",
              "media_type": "Video",
              "notify_marketing_team": "No",
              "transcript": "<h3>Determining a Target Retirement Saving Rate<\/h3><p>A secure retirement is one of your goals, right? The worksheet in this video can help you get there.<\/p><p>When setting up your budget, it is important to include retirement savings. You can save through a retirement plan at work, on your own, or both. The target retirement savings rate tool will help you determine how much you need to save each year. The sooner you start saving, the longer your savings have to grow.<\/p><p>The worksheet will help you estimate what percentage of your current annual salary you should be saving. While it does not take into account your unique circumstances, it will help you plan for your retirement goals.<\/p><p>The worksheet asks for four pieces of information:<\/p><ol><li>Number of years until retirement (your planned retirement age minus your current age)<\/li><li>Current annual salary<\/li><li>Number of years you expect to spend in retirement<\/li><li>Current savings<\/li><\/ol><p>The worksheet assumes that you&rsquo;ll need to replace about 80 percent of your pre-retirement income. Social Security retirement benefits should replace about 40 percent of an average wage earner&rsquo;s income after retiring. This leaves approximately 40 percent to be replaced by retirement savings. Keep in mind, this is an estimate and you may need more or less depending on your individual circumstances.<\/p><h3><strong>How many years do you have left until retirement?<\/strong><\/h3><p>The more years you have until retirement, the less you will have to save each month to reach your goal. No matter your age, for every 10 years you delay starting to save for retirement, you need to save 3 times as much each month to catch up.<\/p><h3><strong>How long will you live in retirement?<\/strong><\/h3><p>Based on current estimates, a 65 year old man can expect to live approximately 18 years in retirement, and a 65 year old woman can expect to live about 20 years, but many people live longer. Planning to live well into your 90s can help you avoid outliving your income.<\/p><p>The worksheet takes into account some factors that impact your retirement savings. First, investing - because it involves risk. Second, inflation - because today&rsquo;s dollars will usually buy less each year as the cost of living rises. Your target savings rate includes any contributions your employer makes to a retirement savings plan for you, such as an employer matching contribution. If, for example, you are in a 401(k) plan in which you contribute 4 percent of your salary and your employer also contributes 4 percent, your saving rate would be 8 percent of your salary.<\/p><p>By using the worksheet, you&rsquo;ve figured out your target savings rate. It gives you a rough idea &ndash;a savings goal. Some may face higher expenses in retirement because of personal circumstances. For example, if you or your spouse have a chronic medical condition, you may want to save more. Some may have other sources of income in retirement such as a traditional pension or money from selling a home that would lower their target savings rate.<\/p><p>If you are not currently saving this amount, don&rsquo;t be discouraged. The important thing is to start saving &ndash; even a small amount &ndash; and increase that amount when you can. Come back and update this worksheet from time to time to reflect changes and track your progress.<\/p><p>Here are a few tips on how to save smart for retirement:<\/p><ul><li>Start now. Time is critical. Start small, if necessary.<\/li><li>Use automatic deductions from your payroll or your checking account.<\/li><li>Make saving for retirement a habit.<\/li><li>Be realistic about investment returns.<\/li><li>If you change jobs, keep your savings in the plan or roll them over to another retirement account.<\/li><li>Don&rsquo;t dip into retirement savings early.<\/li><li>If you pay someone for investment advice, ask them to confirm in writing that they are &ldquo;fiduciaries&rdquo;&mdash;meaning they are obliged to work in your best interest.<\/li><\/ul><p>To track other resources you may have in retirement, start by getting your Social Security statement and an estimate of your retirement benefits on the Social Security Administration&rsquo;s website, <a href=\"http:\/\/www.socialsecurity.gov\/mystatement\" style=\"text-decoration:none;\">www.socialsecurity.gov\/mystatement<\/a>.<\/p><p>The online interactive target retirement savings rate worksheet and other financial planning worksheets are available on EBSA&rsquo;s website: <a href=\"http:\/\/www.dol.gov\/ebsa\" style=\"text-decoration:none;\"><strong>www.dol.gov\/ebsa<\/strong><\/a>. You can save your worksheet data there so that you can come back to update it to track progress or adjust for changes.<\/p><p>You can order a free copy of the Savings Fitness publication or contact a Benefits Advisor with questions electronically at askebsa.dol.gov or by calling toll-free 1-866-444-3272.<\/p><p>Get started today for a secure financial future!<\/p>",
              "schedule_publish": null,
              "archive_date": null,
              "date_last_reviewed": {
                  "value": "2018-01-02 17:00:00",
                  "timezone": "America\/New_York",
                  "timezone_db": "UTC",
                  "date_type": "datetime"
              },
              "content_tags": {
                  "tid": "351",
                  "uuid": "f30deac3-f2d4-4d38-80d3-0c57672f976d",
                  "type": "taxonomy_term",
                  "bundle": "agency_tags"
              },
              "asset_topic_taxonomy": [
                  {
                      "tid": "981",
                      "uuid": "c4ff7aff-ec32-4805-92ef-c237193a635b",
                      "type": "taxonomy_term",
                      "bundle": "asset_topic_taxonomy"
                  }
              ],
              "url": null,
              "high_res_version": null,
              "widget_code": null,
              "priority": "normal",
              "info_for_contact_center": null,
              "workflow_state_search": null,
              "file_media": null,
              "pageType": null
          },
          "72ef2a59-4f2f-4ded-8ab1-7cb301f36207": {
              "title": "Social Security and How It Works",
              "log": "Edited by sandra.abrams@gsa.gov.",
              "status": "1",
              "sticky": null,
              "vuuid": "dc95d7cd-2ecb-4ebe-9b1a-2a19fbbf69f9",
              "nid": "212313",
              "type": "text_content_type",
              "language": "English",
              "created": "1448919639",
              "changed": "1512142969",
              "tnid": null,
              "translate": null,
              "uuid": "72ef2a59-4f2f-4ded-8ab1-7cb301f36207",
              "body": "<h3>What&rsquo;s Social Security?<\/h3><p>Social Security is a federal government program that provides a source of income for you or your legal dependents (spouse, children, or parents) if you qualify for benefits. You also need a Social Security number to get a job.<\/p><p>Find how to apply to get a <a href=\"http:\/\/www.socialsecurity.gov\/ssnumber\/\">Social Security number or to replace your Social Security card<\/a>.<\/p><h3>How Do Benefits Work and How Can I Qualify?<\/h3><p>While you work, you pay Social Security taxes. This tax money goes into a trust fund that pays benefits to those who are currently retired, to people with disabilities, and to the surviving spouses and children of workers who have died. Each year you work, you&rsquo;ll get credits to help you become eligible for benefits when it&rsquo;s time for you to retire. Find all the benefits <a href=\"https:\/\/www.ssa.gov\/\">Social Security Administration (SSA) offers<\/a>.<\/p><h4>There are four main types of benefits that the SSA offers:<\/h4><ul><li><p><a href=\"https:\/\/www.ssa.gov\/retire\/index.html\">Retirement benefits<\/a><\/p><\/li><li><p><a href=\"https:\/\/www.ssa.gov\/planners\/disability\/\">Disability benefits<\/a><\/p><\/li><li><p><a href=\"https:\/\/www.ssa.gov\/planners\/survivors\/\">Benefits for spouses or other survivors of a family member who&#39;s passed<\/a><\/p><\/li><li><p><a href=\"https:\/\/faq.ssa.gov\/link\/portal\/34011\/34019\/Article\/3798\/What-is-the-Supplemental-Security-Income-SSI-program-and-how-can-I-apply\">Supplemental Security Income (SSI) <\/a><\/p><\/li><\/ul><h3>How to Open a &ldquo;my Social Security&rdquo; Account<\/h3><p>If you receive or will receive Social Security benefits, you may want to open a <a href=\"http:\/\/www.socialsecurity.gov\/myaccount\/\">&quot;my Social Security&quot; account<\/a>. This online account is a service from the SSA that allows you to keep track of and manage your SSA benefits, and allows you to make changes to your Social Security record.<\/p><h3>How to Find More Help<\/h3><p>If you have specific questions about your Social Security benefits, you can review the Social Security Administration&rsquo;s <a href=\"https:\/\/faq.ssa.gov\/ics\/support\/default.asp?deptID=34019&amp;_referrer=https:\/\/www.ssa.gov\/ask\/\">frequently asked questions<\/a> or <a href=\"https:\/\/www.ssa.gov\/agency\/contact\/\">contact them directly<\/a>.<\/p>",
              "name": "victoria.wales@gsa.gov",
              "deleted": null,
              "comments": "Nov. 23, 2016 Topic spike revamp. updates published. sa  Nov. 25 fixed structure alignment. sa\r\nMay 31, 2017 CMP 6 month review. sa  Dec. 1, 2017 cmp 6 month review. sa",
              "description": "Learn what Social Security is and how it works.",
              "notify_marketing_team": "No",
              "contact_center_info": null,
              "for_use_by_text": [
                  "USA.gov",
                  "NCC Knowledge Base"
              ],
              "schedule_publish": null,
              "archive_date": null,
              "date_last_reviewed": {
                  "value": "2017-12-01 12:00:00",
                  "timezone": "America\/New_York",
                  "timezone_db": "UTC",
                  "date_type": "datetime"
              },
              "content_tags": {
                  "tid": "341",
                  "uuid": "17b4f321-2aee-4762-a899-f1f82a1d0356",
                  "type": "taxonomy_term",
                  "bundle": "agency_tags"
              },
              "asset_topic_taxonomy": [
                  {
                      "tid": "2799",
                      "uuid": "6d3145aa-ec97-45fd-8d40-341d4cbe8a53",
                      "type": "taxonomy_term",
                      "bundle": "asset_topic_taxonomy"
                  },
                  {
                      "tid": "981",
                      "uuid": "c4ff7aff-ec32-4805-92ef-c237193a635b",
                      "type": "taxonomy_term",
                      "bundle": "asset_topic_taxonomy"
                  }
              ],
              "related_multimedia_two": null,
              "priority": "normal",
              "workflow_state_search": "draft",
              "blog_owner": null,
              "blog_pub_date": "1448989122",
              "usa_feature_toggle_url": null,
              "gob_feature_toggle_url": null,
              "for_use_by": [
                  "USA.gov",
                  "NCC Knowledge Base"
              ],
              "pageType": null
          },
          "9540ef41-35da-4b80-89c2-ef1dad7979a0": {
                "title": "Equifax Data Breach",
                "log": "Edited by marietta.jelks@gsa.gov.",
                "status": "1",
                "sticky": null,
                "vuuid": "a3da4b51-a2d9-470b-9b3b-cca87e55a1b6",
                "nid": "213707",
                "type": "text_content_type",
                "language": "English",
                "created": "1504883588",
                "changed": "1522781856",
                "tnid": null,
                "translate": null,
                "uuid": "9540ef41-35da-4b80-89c2-ef1dad7979a0",
                "body": "<p>Equifax, one of the three major credit reporting agencies in the U.S., announced a data breach that affects 143 million consumers. The hackers accessed Social Security numbers, birthdates, addresses, and driver&rsquo;s license numbers.<\/p><p>Equifax has launched a tool that will let you know if you were affected by the breach. Visit<a href=\"https:\/\/www.equifaxsecurity2017.com\/potential-impact\/\"> Equifax&rsquo;s website dedicated to this breach<\/a> to learn if you were impacted. You will need to provide your last name and the last six numbers of your Social Security number.<\/p><p>If you are impacted, Equifax offers you a free credit monitoring service, TrustedIDPremier. However, you won&rsquo;t be able to enroll in it immediately. You will be given a date when you can return to the site to enroll. Equifax will not send you a reminder to enroll. Mark that date on your calendar, so you can start monitoring your credit as soon as possible.<\/p><p>If you detect suspicious activity on your credit report due to the breach, <a href=\"https:\/\/www.consumerfinance.gov\/ask-cfpb\/how-do-i-dispute-an-error-on-my-credit-report-en-314\/\">learn how to report it<\/a> immediately.<\/p><p>The FTC also offers more information to <a href=\"https:\/\/www.consumer.ftc.gov\/blog\/2017\/09\/equifax-data-breach-what-do\">protect yourself after a data breach<\/a>. Learn how to report and recover from identity theft at <a href=\"https:\/\/identitytheft.gov\/\">IdentityTheft.gov<\/a>.<\/p>",
                "name": "marietta.jelks@gsa.gov",
                "deleted": null,
                "comments": null,
                "description": "Learn how to protect yourself after the Equifax data breach.",
                "notify_marketing_team": "No",
                "contact_center_info": null,
                "for_use_by_text": [
                    "USA.gov",
                    "NCC Knowledge Base"
                ],
                "schedule_publish": null,
                "archive_date": null,
                "date_last_reviewed": null,
                "content_tags": null,
                "asset_topic_taxonomy": [
                    {
                        "tid": "2762",
                        "uuid": "be12502a-80fd-46f2-9690-f79b8c2c1891",
                        "type": "taxonomy_term",
                        "bundle": "asset_topic_taxonomy"
                    },
                    {
                        "tid": "2760",
                        "uuid": "eefb2699-84df-4283-9eb0-64bf7835fb31",
                        "type": "taxonomy_term",
                        "bundle": "asset_topic_taxonomy"
                    },
                    {
                        "tid": "1251",
                        "uuid": "99d3ab94-718b-4c2d-ac52-f3b55629fbef",
                        "type": "taxonomy_term",
                        "bundle": "asset_topic_taxonomy"
                    },
                    {
                        "tid": "10664",
                        "uuid": "25120736-d07e-4a7b-9315-500b0b1fc647",
                        "type": "taxonomy_term",
                        "bundle": "asset_topic_taxonomy"
                    }
                ],
                "related_multimedia_two": {
                    "target_id": "213712",
                    "uuid": "3ec50518-1659-4506-80d2-0686d2be626e",
                    "type": "node",
                    "bundle": "multimedia_content_type"
                },
                "priority": "normal",
                "workflow_state_search": null,
                "blog_owner": null,
                "blog_pub_date": "1504883593",
                "usa_feature_toggle_url": null,
                "gob_feature_toggle_url": null,
                "for_use_by": [
                    "USA.gov",
                    "NCC Knowledge Base"
                ],
                "pageType": null
            },
            "3ec50518-1659-4506-80d2-0686d2be626e": {
                "title": "equifax",
                "log": "Edited by julia.sultan@gsa.gov.",
                "status": "1",
                "sticky": null,
                "vuuid": "a35f840b-7877-4f1d-b401-b3b434e581e4",
                "nid": "213712",
                "type": "multimedia_content_type",
                "language": "English",
                "created": "1505244930",
                "changed": "1517862618",
                "tnid": null,
                "translate": null,
                "uuid": "3ec50518-1659-4506-80d2-0686d2be626e",
                "name": "puthorn.suwannasingh@gsa.gov",
                "deleted": null,
                "alt_text": "Security icon and Computer monitor behind",
                "comments": null,
                "description": "Featured image for USA.gov",
                "embed_code": null,
                "for_use_by": "USA.gov",
                "media_type": "Image",
                "notify_marketing_team": "No",
                "transcript": null,
                "schedule_publish": null,
                "archive_date": null,
                "date_last_reviewed": null,
                "content_tags": null,
                "asset_topic_taxonomy": [],
                "url": null,
                "high_res_version": null,
                "widget_code": null,
                "priority": "normal",
                "info_for_contact_center": null,
                "workflow_state_search": null,
                "file_media": {
                    "fid": "79bcc01b-9cd0-4fe2-8cd8-9d8ec507e1a9",
                    "uid": "0912ea57-427e-4e72-af5e-6335a8ba177c",
                    "filename": "Topic_Equifax.jpg",
                    "uri": "\/\/app_usa_prod_eqffnyamdzrb.s3.amazonaws.com\/Topic_Equifax.jpg",
                    "filemime": "image\/jpeg",
                    "filesize": "69017",
                    "status": "1",
                    "timestamp": "1505244925",
                    "type": "image",
                    "uuid": "79bcc01b-9cd0-4fe2-8cd8-9d8ec507e1a9",
                    "field_file_image_alt_text": [],
                    "field_file_image_title_text": [],
                    "_drafty_revision_requested": "FIELD_LOAD_CURRENT",
                    "rdf_mapping": [],
                    "metadata": {
                        "height": 582,
                        "width": 600
                    },
                    "height": "582",
                    "width": "600",
                    "alt": null,
                    "title": null
                },
                "pageType": null
            },
          "de360a7e-14f9-4656-8037-0ba1adfce65a": {
              "title": "Protecting Your Private Pension Benefits",
              "log": "Edited by jessica.milcetich@gsa.gov.",
              "status": "1",
              "sticky": null,
              "vuuid": "9769be69-6742-4cc9-8ce0-f3d793ce7db8",
              "nid": "37502",
              "type": "text_content_type",
              "language": "English",
              "created": "1420477124",
              "changed": "1523885589",
              "tnid": null,
              "translate": null,
              "uuid": "de360a7e-14f9-4656-8037-0ba1adfce65a",
              "body": "<h3>Avoiding Errors and Getting Help<\/h3><p>If your job is covered by a traditional pension plan, make sure you get the pension amount you&#39;re owed.&nbsp;<\/p><ul><li>Find ways to protect yourself by reading these&nbsp;<a href=\"http:\/\/www.dol.gov\/ebsa\/Publications\/10common.html\">10 common causes of errors in pension calculation<\/a>.<\/li><li>Get&nbsp;<a href=\"http:\/\/www.pensionrights.org\/find-help\">free legal help<\/a>&nbsp;if you&#39;re experiencing a problem with your pension plan.<\/li><li>Find out whether&nbsp;your&nbsp;<a href=\"http:\/\/www.irs.gov\/uac\/About-Publication-575\">pension or annuity income is taxable<\/a>.<\/li><li>If you have questions or complaints about your employer-sponsored pension plan, contact your human resources office or locate the&nbsp;<a href=\"https:\/\/www.dol.gov\/agencies\/ebsa\/about-ebsa\/about-us\/regional-offices\">Employee Benefits Security Administration (EBSA) regional office<\/a>&nbsp;near you.<\/li><\/ul><h3>Federal Insurance for Private Pensions<\/h3><p>If you&#39;ve earned a traditional pension, you&#39;re likely to receive it even if your company runs into financial problems.&nbsp;<\/p><p>The&nbsp;<a href=\"https:\/\/www.pbgc.gov\/\">Pension Benefit Guaranty Corporation<\/a> (PBGC):<\/p><ul><li>Insures most <a href=\"http:\/\/www.pbgc.gov\/wr\/find-an-insured-pension-plan\/pbgc-protects-pensions.html\">private-sector defined-benefit pensions<\/a> that typically pay a certain amount each month after you retire<\/li><li>Covers most <a href=\"http:\/\/www.dol.gov\/ebsa\/FAQs\/faq_consumer_cashbalanceplans.html\">cash-balance plans<\/a>, a type of defined-benefit pension that allows you to take a lump-sum distribution<\/li><li><strong>Does not<\/strong> cover&nbsp;<a href=\"\/benefits-for-federal-employees\">government<\/a> and <a href=\"\/military-pay\">military pensions<\/a>, 401k plans,&nbsp;IRAs, and certain&nbsp;other plans.<\/li><\/ul><h4>Is Your Pension Insured?<\/h4><ul><li>To see if your pension is insured, search PBGC&#39;s <a href=\"http:\/\/search.pbgc.gov\/search\/InsuredPlans\/InsuredPlans?query=&amp;ipcol=nc&amp;filter=c&amp;tab=ip&amp;ip_type=c&amp;page=1\/\">list of single-employer and multi-employer plans<\/a>.<\/li><li>If your plan is insured and it ends without enough money to pay all benefits,&nbsp;PBGC&nbsp;will pay you the money you&rsquo;re owed, up to&nbsp;<a href=\"http:\/\/www.pbgc.gov\/wr\/benefits\/guaranteed-benefits.html\">legal limits<\/a>.<\/li><li>To learn more about PBGC-insured pensions, view these <a href=\"http:\/\/www.pbgc.gov\/about\/faq.html\">frequently asked questions<\/a>.<\/li><\/ul><h3>Find an Unclaimed Pension<\/h3><p>More than 38 million people in the U.S.&nbsp;haven&rsquo;t claimed pension benefits&nbsp;they have earned.&nbsp;Find out if you, or someone you know, is&nbsp;<a href=\"http:\/\/search.pbgc.gov\/mp\/mp.aspx\">owed a pension<\/a>.<\/p>",
              "name": "carolyn.cihelka@gsa.gov",
              "deleted": null,
              "comments": "Reworked and tightened asset.--Carolyn, 11\/23\/2016\r\n\r\nCreate links to the For Federal Employees, Active Duty Servicemembers, Veterans and Benefits pages where mentioned in the last two sections.\r\n\r\nThere is no link directly to the \"benefits\" section of social security - added the link to Social Security home page (Arlene)\r\n\r\nUpdated the EBSA regional offices link. SAM 8\/22\/16\r\n\r\n8\/23\/16: This is up for a full review, so  please review, update the Date Last Reviewed and send back to me. Thanks.--CC\r\n",
              "description": "Learn about protections the government provides for most traditional private pension plans.",
              "notify_marketing_team": "No",
              "contact_center_info": null,
              "for_use_by_text": [
                  "USA.gov",
                  "NCC Knowledge Base"
              ],
              "schedule_publish": null,
              "archive_date": null,
              "date_last_reviewed": {
                  "value": "2018-01-02 17:00:00",
                  "timezone": "America\/New_York",
                  "timezone_db": "UTC",
                  "date_type": "datetime"
              },
              "content_tags": [
                  {
                      "tid": "2684",
                      "uuid": "588631b7-b14c-46f9-8eaf-3f1274114813",
                      "type": "taxonomy_term",
                      "bundle": "agency_tags"
                  },
                  {
                      "tid": "351",
                      "uuid": "f30deac3-f2d4-4d38-80d3-0c57672f976d",
                      "type": "taxonomy_term",
                      "bundle": "agency_tags"
                  },
                  {
                      "tid": "221",
                      "uuid": "948fe154-eed9-4817-9839-2a1e3ff623d2",
                      "type": "taxonomy_term",
                      "bundle": "agency_tags"
                  }
              ],
              "asset_topic_taxonomy": [
                  {
                      "tid": "981",
                      "uuid": "c4ff7aff-ec32-4805-92ef-c237193a635b",
                      "type": "taxonomy_term",
                      "bundle": "asset_topic_taxonomy"
                  }
              ],
              "related_multimedia_two": null,
              "priority": "normal",
              "workflow_state_search": "published",
              "blog_owner": null,
              "blog_pub_date": null,
              "usa_feature_toggle_url": null,
              "gob_feature_toggle_url": null,
              "for_use_by": [
                  "USA.gov",
                  "NCC Knowledge Base"
              ],
              "pageType": null
          },
          "021aab4f-0cc9-4c1c-b4b6-cfcbd72f44f8": {
              "title": "Civil Service Retirement",
              "log": "Edited by jessica.milcetich@gsa.gov.",
              "status": "1",
              "sticky": null,
              "vuuid": "cff989dc-8acd-4d52-927e-e3cab4b2f278",
              "nid": "36427",
              "type": "text_content_type",
              "language": "English",
              "created": "1420477059",
              "changed": "1523887943",
              "tnid": null,
              "translate": null,
              "uuid": "021aab4f-0cc9-4c1c-b4b6-cfcbd72f44f8",
              "body": "<h3>Federal Employee Retirement Planning and Management<\/h3><p>If you are a federal employee planning to retire or a federal retiree looking for information about your benefits, the <a href=\"http:\/\/www.opm.gov\/retirement-services\/\">U.S. Office of Personnel Management (OPM)&#39;s Retirement page<\/a>&nbsp;can help you:<\/p><ul><li>Research and learn about <a href=\"http:\/\/www.opm.gov\/retirement-services\/federal-employees\/\">retirement options<\/a>.<\/li><li><a href=\"https:\/\/www.servicesonline.opm.gov\/\">Manage your benefits online<\/a>.<\/li><li>Find options for signing up for&nbsp;<a href=\"https:\/\/www.opm.gov\/retirement-services\/my-annuity-and-benefits\/annuity-payments\/#url=Direct-Deposit\">direct deposit<\/a>. If you receive paper checks now, you&#39;ll soon be required to switch to direct deposit or Direct Express debit card.<\/li><li>Find answers to <a href=\"http:\/\/www.opm.gov\/retirement-services\/retirement-faqs\/\">frequently asked questions about retirement<\/a>.<\/li><\/ul><p>If you are the survivor of a deceased&nbsp;federal employee or federal retiree, you may be eligible for <a href=\"https:\/\/www.opm.gov\/retirement-services\/my-annuity-and-benefits\/life-events\/#url=DeathSurvivors\">death and survivor benefits<\/a>. Visit the OPM website to <a href=\"https:\/\/www.opm.gov\/retirement-services\/my-annuity-and-benefits\/life-events\/death\/report-of-death\/\">report the&nbsp;death and&nbsp;apply for&nbsp;death benefits<\/a>.&nbsp;<\/p><h4>Thrift Savings Plan<\/h4><p>In addition to the defined or basic benefits provided by your <a href=\"https:\/\/www.opm.gov\/retirement-services\/csrs-information\/\">Civil Service Retirement System (CSRS)<\/a>&nbsp;or <a href=\"https:\/\/www.opm.gov\/retirement-services\/fers-information\/\">Federal Employee Retirement System (FERS)<\/a>&nbsp;plan, if you are a current federal employee, you can boost your retirement savings by participating in the <a href=\"https:\/\/www.opm.gov\/retirement-services\/my-annuity-and-benefits\/thrift-savings-plan\/\">Thrift Savings Plan (TSP)<\/a>. The TSP offers the same types of savings and tax benefits as a 401(k) plan.<\/p><h4>Credit for Military Service<\/h4><p>Military service does not automatically count toward civil service retirement.<\/p><ul><li>To <a href=\"https:\/\/www.opm.gov\/retirement-services\/fers-information\/service-credit\/#military\">receive credit for military service performed after 1956<\/a>,&nbsp;you must pay a deposit.&nbsp;<\/li><li>If you are a military retiree, you generally cannot receive military service credit towards your civilian retirement unless you <a href=\"https:\/\/www.opm.gov\/retirement-services\/fers-information\/military-retired-pay\/\">waive your military retired pay<\/a>.<\/li><\/ul><h4>Pension Taxes<\/h4><p>The Internal Revenue Service (IRS) offers an&nbsp;<a href=\"https:\/\/www.irs.gov\/help\/ita\/is-my-pension-or-annuity-payment-taxable\">online tool<\/a>&nbsp;and an&nbsp;<a href=\"https:\/\/www.irs.gov\/forms-pubs\/about-publication-575\">online publication<\/a>&nbsp;to help you determine whether or not your pension or annuity payment is taxable.<\/p><h4>Contact OPM&#39;s Retirement Operations Center<\/h4><p>For benefits information or help with a transaction, contact <a href=\"http:\/\/www.opm.gov\/retirement-services\/contact-retirement\/\">OPM&#39;s Retirement Operations Center<\/a>.<\/p><h3>State and Local Government Employees<\/h3><p>If you are a state or local government employee and have questions about your pension plan, contact your agency&#39;s personnel department. You can also contact&nbsp;the&nbsp;<a href=\"https:\/\/www.dol.gov\/agencies\/ebsa\">Employee Benefits Security Administration (EBSA)<\/a>&nbsp;for help.<\/p>",
              "name": "mary.goetzinger@gsa.gov",
              "deleted": null,
              "comments": "8\/8\/2016: I MOVED sections about pension taxes and State & Local Gov't employees to this asset FROM the Pension Benefits for Government Employees, Military, and Veterans asset. I will REMOVE those sections from Pension Benefits for Government Employees, Military, and Veterans, rename it simply Pension Benefits for Military and Veterans, and update that one with info about the new military retirement system. \r\n \r\n1\/25\/2016: Added\/changed a line about signing up for DD. Added section about TSP.--Carolyn\r\n8\/4\/2015 Carolyn: Took the line about reporting a death out of the list of things the federal employee can do, and made a separate paragraph for survivors. I also changed the whole section about combining military service with civil service retirement. It was confusing and used the wrong link for the first item before. I added a second line about waiving military retiree pay. \r\n\r\n",
              "description": "Get information on federal retirement benefits.",
              "notify_marketing_team": "No",
              "contact_center_info": null,
              "for_use_by_text": [
                  "USA.gov",
                  "NCC Knowledge Base"
              ],
              "schedule_publish": null,
              "archive_date": null,
              "date_last_reviewed": {
                  "value": "2018-01-02 17:00:00",
                  "timezone": "America\/New_York",
                  "timezone_db": "UTC",
                  "date_type": "datetime"
              },
              "content_tags": {
                  "tid": "301",
                  "uuid": "538c0d18-c7f7-44bc-bda0-5fec77450227",
                  "type": "taxonomy_term",
                  "bundle": "agency_tags"
              },
              "asset_topic_taxonomy": [
                  {
                      "tid": "981",
                      "uuid": "c4ff7aff-ec32-4805-92ef-c237193a635b",
                      "type": "taxonomy_term",
                      "bundle": "asset_topic_taxonomy"
                  },
                  {
                      "tid": "2704",
                      "uuid": "49aa02bf-6bef-476d-a0e1-8315b4154953",
                      "type": "taxonomy_term",
                      "bundle": "asset_topic_taxonomy"
                  }
              ],
              "related_multimedia_two": null,
              "priority": "normal",
              "workflow_state_search": "published",
              "blog_owner": null,
              "blog_pub_date": null,
              "usa_feature_toggle_url": null,
              "gob_feature_toggle_url": null,
              "for_use_by": [
                  "USA.gov",
                  "NCC Knowledge Base"
              ],
              "pageType": null
          },
          "4b2ed85b-7910-4584-9cef-4c2fca5328ee": {
                "title": "National Prevention Week 2018",
                "log": "Created by edgardo.morales@gsa.gov.",
                "status": "1",
                "sticky": null,
                "vuuid": "96fd581c-b87e-4d9e-8360-7889832140a3",
                "nid": "213987",
                "type": "multimedia_content_type",
                "language": "English",
                "created": "1524775949",
                "changed": "1524775951",
                "tnid": null,
                "translate": null,
                "uuid": "4b2ed85b-7910-4584-9cef-4c2fca5328ee",
                "name": "edgardo.morales@gsa.gov",
                "deleted": null,
                "alt_text": "National Prevention Week 2018 Hashtag Dear Future Me.",
                "comments": null,
                "description": "National Prevention Week 2018 #DearFutureMe",
                "embed_code": null,
                "for_use_by": [
                    "USA.gov"
                ],
                "media_type": "Image",
                "notify_marketing_team": "No",
                "transcript": null,
                "schedule_publish": null,
                "archive_date": null,
                "date_last_reviewed": null,
                "content_tags": {
                    "tid": "271",
                    "uuid": "7ef7035c-37fb-48ec-a27e-0eec34f923bc",
                    "type": "taxonomy_term",
                    "bundle": "agency_tags"
                },
                "asset_topic_taxonomy": [],
                "url": null,
                "high_res_version": null,
                "widget_code": "",
                "priority": "normal",
                "info_for_contact_center": null,
                "workflow_state_search": null,
                "file_media": {
                    "fid": "6778",
                    "uid": "1917",
                    "filename": "NPW2018.jpg",
                    "uri": "\/\/app_usa_stg_eqffnyamdzrb.s3.amazonaws.com\/Dear Future Me_v2_600x580_0.jpg",
                    "filemime": "image\/jpeg",
                    "filesize": "227349",
                    "status": "1",
                    "timestamp": "1524775943",
                    "type": "image",
                    "uuid": "f4a2d61c-adcd-49ea-ba56-c60b1f20d83a",
                    "field_file_image_alt_text": {
                        "und": "National Prevention Week 2018 Hashtag Dear Future Me."
                    },
                    "field_file_image_title_text": [],
                    "_drafty_revision_requested": "FIELD_LOAD_CURRENT",
                    "rdf_mapping": [],
                    "alt": "National Prevention Week 2018 Hashtag Dear Future Me.",
                    "metadata": {
                        "height": 2417,
                        "width": 2500
                    },
                    "height": "2417",
                    "width": "2500",
                    "title": null
                },
                "pageType": null
            },
          "5ae18b1e-bc6c-4623-add6-4732e88ea8b5": {
                  "tid": "11743",
                  "vid": "42",
                  "name": "Presidential Election Process 2",
                  "description": null,
                  "format": null,
                  "weight": null,
                  "changed": "1524850020",
                  "uuid": "5ae18b1e-bc6c-4623-add6-4732e88ea8b5",
                  "vocabulary_machine_name": "site_strucutre_taxonomy",
                  "path": "1",
                  "type": "taxonomy_term",
                  "deleted": null,
                  "parent_uuid": "773d7b32-4c6d-4120-8c23-bdc44dba9e8c",
                  "parent": "10724",
                  "children": [],
                  "page_intro": "Learn about the Presidential election process and the national conventions.",
                  "head_html": "<style>\r\n  .dottedUnderline { border-bottom: 2px dotted; }\r\n<\/style>",
                  "end_html": null,
                  "generate_page": "yes",
                  "also_include_on_nav_page": [],
                  "asset_topic_taxonomy": [
                      {
                          "tid": "11742",
                          "uuid": "982add29-ee0e-45b6-a10f-55ceaf5af6c1",
                          "type": "taxonomy_term",
                          "bundle": "asset_topic_taxonomy"
                      }
                  ],
                  "page_title": "Presidential Election Process",
                  "browser_title": "Presidential Election Process",
                  "friendly_url": "\/election2",
                  "usa_gov_toggle_url": null,
                  "gobiernousa_gov_toggle_url": null,
                  "type_of_page_to_generate": "generic-content-page",
                  "asset_inherit_carousel": "0",
                  "asset_inherit_content": "0",
                  "asset_inherit_sidebar": "0",
                  "asset_inherit_bottom": "0",
                  "asset_order_carousel": [],
                  "asset_order_content": [
                      {
                          "target_id": "213876",
                          "uuid": "3bdf55da-8822-446e-9d86-f3b2605ad3de",
                          "type": "node",
                          "bundle": "html_content_type"
                      },
                      {
                          "target_id": "213875",
                          "uuid": "00d8f85f-745a-427f-9052-e30c98f952e7",
                          "type": "node",
                          "bundle": "html_content_type"
                      }
                  ],
                  "asset_order_sidebar": [],
                  "asset_order_bottom": [],
                  "asset_inherit_menu": "0",
                  "asset_order_menu": null,
                  "generate_menu": "yes",
                  "css_class": null,
                  "usa_gov_50_state_category": null,
                  "directory_record_access_me": null,
                  "directory_record_url": null,
                  "home_alert_asset": null,
                  "show_social_media_icon": "No",
                  "term_owner": null,
                  "help_desk": null,
                  "usa_gov_50_state_prefix": null,
                  "home_howdoi_assets": [],
                  "home_whats_new_asset": [],
                  "government_branch": null,
                  "real_meta_description": "Learn about the Presidential election process and the national conventions.",
                  "description_meta": "Learn about the Presidential election process and the national conventions.",
                  "for_use_by": [
                      "USA.gov"
                  ],
                  "pageType": "GenericContentPage",
                  "menu": [],
                  "child_pages": []
              },
              "3bdf55da-8822-446e-9d86-f3b2605ad3de": {
                  "title": "Overview of the Presidential Election Process",
                  "log": "Edited by arlene.hernandez@gsa.gov.",
                  "status": "1",
                  "sticky": null,
                  "vuuid": "47fdd5c0-deef-419c-88a5-6d16f7b24bdb",
                  "nid": "213876",
                  "type": "html_content_type",
                  "language": "English",
                  "created": "1524164959",
                  "changed": "1524843679",
                  "tnid": null,
                  "translate": null,
                  "uuid": "3bdf55da-8822-446e-9d86-f3b2605ad3de",
                  "name": "arlene.hernandez@gsa.gov",
                  "deleted": null,
                  "comments": "This is the test asset for our usability test. The dotted underline with a question mark.",
                  "description": "This is the test asset for our usability test. The dotted underline with a question mark.",
                  "for_use_by": [
                      "USA.gov"
                  ],
                  "html": "<p>An election for President of the United States occurs every four years on Election Day, held the first Tuesday after the first Monday in November. The next Presidential election will be held on November 3, 2020.<\/p><p id=\"facetedsearch\">The <a href=\"http:\/\/www.loc.gov\/teachers\/classroommaterials\/presentationsandactivities\/presentations\/elections\/election-process.html\">election process<\/a> begins with the <a href=\"https:\/\/www.usa.gov\/election#item-37162\">primary elections and caucuses<\/a> and moves to <a href=\"https:\/\/www.usa.gov\/election#item-212585\">nominating conventions<\/a>, during which political parties each select a <span class=\"tooltip dottedUnderline\" role=\"tooltip\" tabindex=\"0\">nominee\r\n                                    <span aria-label=\"Tooltip - Nominee: The final candidate chosen by a party to represent them in an election.\"><\/span>\r\n                                    <span class=\"tooltiptext\" data-gtm-vis-first-on-screen-6221628_233=\"8882\" data-gtm-vis-recent-on-screen-6221628_233=\"418849\" data-gtm-vis-total-visible-time-6221628_233=\"100\" data-gtm-vis-has-fired-6221628_233=\"1\">Nominee: The final candidate chosen by a party to represent them in an election.<\/span><img class=\"tooltip-icon\" src=\"\/sites\/all\/themes\/usa\/images\/Icon_Tooltip_sm02.png\" alt=\"Definition of the term Nominee\" aria-hidden=\"true\"><\/span> to unite behind. The nominee also announces a Vice Presidential running mate at this time. The candidates then <a href=\"https:\/\/www.usa.gov\/election#item-212586\">campaign across the country<\/a> to explain their views and plans to voters and participate in debates with candidates from other parties.<\/p><p id=\"facetedsearch\">During the <span class=\"tooltip dottedUnderline\" role=\"tooltip\" tabindex=\"0\">general election \r\n                                    <span aria-label=\"Tooltip - General Election: A final election for a political office with a limited list of candidates.\"><\/span>\r\n                                    <span class=\"tooltiptext\" data-gtm-vis-first-on-screen-6221628_233=\"8882\" data-gtm-vis-recent-on-screen-6221628_233=\"418849\" data-gtm-vis-total-visible-time-6221628_233=\"100\" data-gtm-vis-has-fired-6221628_233=\"1\">General Election: A final election for a political office with a limited list of candidates.<\/span><img class=\"tooltip-icon\" src=\"\/sites\/all\/themes\/usa\/images\/Icon_Tooltip_sm02.png\" alt=\"Definition of the term General Election\u201c aria-hidden=\"true\"><\/span>, Americans go to their <span class=\"tooltip dottedUnderline\" role=\"tooltip\" tabindex=\"0\">polling place  \r\n                                    <span aria-label=\"Tooltip - Polling Place: The location in which you cast your vote.\"><\/span>\r\n                                    <span class=\"tooltiptext\" data-gtm-vis-first-on-screen-6221628_233=\"8882\" data-gtm-vis-recent-on-screen-6221628_233=\"418849\" data-gtm-vis-total-visible-time-6221628_233=\"100\" data-gtm-vis-has-fired-6221628_233=\"1\">Polling Place: The location in which you cast your vote.<\/span><img class=\"tooltip-icon\" src=\"\/sites\/all\/themes\/usa\/images\/Icon_Tooltip_sm02.png\" alt=\"Definition of the term Polling Place\u201c aria-hidden=\"true\"><\/span> to cast their vote for President. But the tally of those votes&mdash;the popular vote&mdash;does not determine the winner. Instead, Presidential elections use the <a href=\"https:\/\/www.usa.gov\/election#item-36072\">Electoral College<\/a>. To win the election, a candidate must receive a majority of electoral votes. In the event no candidate receives the majority, the House of Representatives chooses the President and the Senate chooses the Vice President.<\/p><p>The Presidential election process follows a typical cycle:<\/p><ul><li>Spring of the year before an election &ndash; Candidates announce their intentions to run.<\/li><li id=\"facetedsearch\">Summer of the year before an election through spring of the election year &ndash;&nbsp;Primary and <span class=\"tooltip dottedUnderline\" role=\"tooltip\" tabindex=\"0\">caucus   \r\n                                    <span aria-label=\"Tooltip - Caucus: A statewide meeting held by members of a political party to choose a Presidential candidate to support.\"><\/span>\r\n                                    <span class=\"tooltiptext\" data-gtm-vis-first-on-screen-6221628_233=\"8882\" data-gtm-vis-recent-on-screen-6221628_233=\"418849\" data-gtm-vis-total-visible-time-6221628_233=\"100\" data-gtm-vis-has-fired-6221628_233=\"1\">Caucus: A statewide meeting held by members of a political party to choose a Presidential candidate to support.<\/span><img class=\"tooltip-icon\" src=\"\/sites\/all\/themes\/usa\/images\/Icon_Tooltip_sm02.png\" alt=\"Definition of the term Caucus\u201c aria-hidden=\"true\"><\/span> debates take place.<\/li><li id=\"facetedsearch\">January to June of election year &ndash; States and parties hold <span class=\"tooltip dottedUnderline\" role=\"tooltip\" tabindex=\"0\">primaries    \r\n                                    <span aria-label=\"Tooltip - Primary: An election held to determine which of a party's candidates will receive that party's nomination and be their sole candidate later in the general election.\"><\/span>\r\n                                    <span class=\"tooltiptext\" data-gtm-vis-first-on-screen-6221628_233=\"8882\" data-gtm-vis-recent-on-screen-6221628_233=\"418849\" data-gtm-vis-total-visible-time-6221628_233=\"100\" data-gtm-vis-has-fired-6221628_233=\"1\">Primary: An election held to determine which of a party's candidates will receive that party's nomination and be their sole candidate later in the general election.<\/span><img class=\"tooltip-icon\" src=\"\/sites\/all\/themes\/usa\/images\/Icon_Tooltip_sm02.png\" alt=\"Definition of the term Primary\u201c aria-hidden=\"true\"><\/span> and caucuses.<\/li><li>July to early September &ndash; Parties hold nominating conventions to choose their candidates.<\/li><li>September and October &ndash; Candidates participate in&nbsp;Presidential debates.<\/li><li>Early November &ndash; Election Day<\/li><li id=\"facetedsearch\">December &ndash; <span class=\"tooltip dottedUnderline\" role=\"tooltip\" tabindex=\"0\">Electors     \r\n                                    <span aria-label=\"Tooltip - Elector: A person who is certified to represent their state's vote in the Electoral College.\"><\/span>\r\n                                    <span class=\"tooltiptext\" data-gtm-vis-first-on-screen-6221628_233=\"8882\" data-gtm-vis-recent-on-screen-6221628_233=\"418849\" data-gtm-vis-total-visible-time-6221628_233=\"100\" data-gtm-vis-has-fired-6221628_233=\"1\">Elector: A person who is certified to represent their state's vote in the Electoral College.<\/span><img class=\"tooltip-icon\" src=\"\/sites\/all\/themes\/usa\/images\/Icon_Tooltip_sm02.png\" alt=\"Definition of the term Elector\u201c aria-hidden=\"true\"><\/span> cast their votes in the Electoral College.<\/li><li>Early January of the next calendar year &ndash; Congress counts the electoral votes.<\/li><li>January 20 &ndash; Inauguration Day<\/li><\/ul><p>For an in-depth look at the federal election process in the U.S., check out <a href=\"https:\/\/share.america.gov\/wp-content\/uploads\/2016\/04\/Elections-USA_In-Brief-Series_English_Lo-Res.pdf\">USA In Brief: ELECTIONS<\/a>.<\/p> ",
                  "notify_marketing_team": "No",
                  "priority": "normal",
                  "schedule_publish": null,
                  "archive_date": null,
                  "date_last_reviewed": null,
                  "content_tags": null,
                  "asset_topic_taxonomy": [
                      {
                          "tid": "11742",
                          "uuid": "982add29-ee0e-45b6-a10f-55ceaf5af6c1",
                          "type": "taxonomy_term",
                          "bundle": "asset_topic_taxonomy"
                      }
                  ],
                  "workflow_state_search": null,
                  "blog_pub_date": "1524164962",
                  "blog_owner": null,
                  "gob_feature_toggle_url": null,
                  "usa_feature_toggle_url": null,
                  "pageType": null
              },
              "00d8f85f-745a-427f-9052-e30c98f952e7": {
                  "title": "National Conventions",
                  "log": "Edited by arlene.hernandez@gsa.gov.",
                  "status": "1",
                  "sticky": null,
                  "vuuid": "96724738-2394-469a-8b08-d26694a739d5",
                  "nid": "213875",
                  "type": "html_content_type",
                  "language": "English",
                  "created": "1524151426",
                  "changed": "1524843719",
                  "tnid": null,
                  "translate": null,
                  "uuid": "00d8f85f-745a-427f-9052-e30c98f952e7",
                  "name": "arlene.hernandez@gsa.gov",
                  "deleted": null,
                  "comments": "This asset will be used as part of a usability test.",
                  "description": "This asset will be used as part of a usability test.",
                  "for_use_by": [
                      "USA.gov"
                  ],
                  "html": "<p>After the primaries and caucuses, most <a href=\"https:\/\/www.fas.org\/sgp\/crs\/misc\/R42533.pdf\">political parties hold national conventions<\/a> to finalize their choice for their Presidential and Vice Presidential nominees.<\/p><p>The national conventions typically confirm the candidate who has already won the required number of delegates through the primaries and caucuses. However, if no candidate has received the majority of a party's delegates, the convention becomes the stage for choosing that party's Presidential nominee.<\/p><h3>Delegates: Types and Numbers Required<\/h3><p>Read an overview of <a href=\"https:\/\/www.cfr.org\/backgrounder\/us-presidential-nominating-process\">the delegate process for becoming the nominee<\/a> of the Republican or Democratic party in a presidential election now.<\/p><p>Some parties require a <a href=\"https:\/\/www.cfr.org\/backgrounder\/us-presidential-nominating-process\">specific number of delegates<\/a> a candidate needs to win his or her party's nomination.<\/p><p>There are two main types of delegates:<\/p><ul><li><a href=\"https:\/\/www.cfr.org\/backgrounder\/us-presidential-nominating-process\">Pledged, or bound, delegates<\/a>, who are required to support the candidate to whom they were awarded through the primary or caucus process<\/li><li>Unpledged, or unbound delegates, or <a href=\"https:\/\/www.cfr.org\/backgrounder\/us-presidential-nominating-process\">superdelegates<\/a>, who are free to support any Presidential candidate of their choosing<\/li><\/ul><h3>Brokered and Contested Conventions<\/h3><p>If no nominee has a party's majority of delegates going into its convention, then the delegates pick their Presidential candidate in a <a href=\"https:\/\/www.cfr.org\/backgrounder\/us-presidential-nominating-process\">brokered or contested convention<\/a>. Pledged delegates usually have to vote for the candidate they were awarded to in the first round of voting, while unpledged delegates don't. Pledged delegates may be allowed to choose any candidate in subsequent rounds of voting. Balloting continues until one nominee receives the required majority to win.<\/p>  ",
                  "notify_marketing_team": "No",
                  "priority": "normal",
                  "schedule_publish": null,
                  "archive_date": null,
                  "date_last_reviewed": null,
                  "content_tags": null,
                  "asset_topic_taxonomy": [
                      {
                          "tid": "11740",
                          "uuid": "5c90785a-b37f-4118-9b4f-8a43ae76dc05",
                          "type": "taxonomy_term",
                          "bundle": "asset_topic_taxonomy"
                      },
                      {
                          "tid": "11742",
                          "uuid": "982add29-ee0e-45b6-a10f-55ceaf5af6c1",
                          "type": "taxonomy_term",
                          "bundle": "asset_topic_taxonomy"
                      }
                  ],
                  "workflow_state_search": null,
                  "blog_pub_date": "1524151428",
                  "blog_owner": null,
                  "gob_feature_toggle_url": null,
                  "usa_feature_toggle_url": null,
                  "pageType": null
              },
        }
      }
    }
    ],
}
