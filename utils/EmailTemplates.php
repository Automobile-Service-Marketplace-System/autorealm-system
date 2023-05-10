<?php

namespace app\utils;

class EmailTemplates
{
    static public function appointmentConfirmationTemplate(string $imageUrl, string $date, string $timeslot): string
    {
        return "<!doctype html>
                <html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office' lang='en-Us'>

                <head>
                    <title>
                    </title>
  <!--[if !mso]><!-->
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <!--<![endif]-->
  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <style type='text/css'>
            #outlook a {
            padding: 0;
    }

body {
margin: 0;
padding: 0;
-webkit-text-size-adjust: 100%;
-ms-text-size-adjust: 100%;
}

table,
    td {
    border-collapse: collapse;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }

    img {
    border: 0;
    height: auto;
    line-height: 100%;
      outline: none;
      text-decoration: none;
      -ms-interpolation-mode: bicubic;
    }

    p {
    display: block;
    margin: 13px 0;
    }
  </style>
  <!--[if mso]>
        <noscript>
        <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG/>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
        </xml>
        </noscript>
        <![endif]-->
  <!--[if lte mso 11]>
        <style type='text/css'>
          .mj-outlook-group-fix { width:100% !important; }
        </style>
        <![endif]-->
  <!--[if !mso]><!-->
  <link href='https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
  <style type='text/css'>
    @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
  </style>
  <!--<![endif]-->
  <style type='text/css'>
    @media only screen and (min-width:480px) {
    .mj-column-per-100 {
        width: 100% !important;
        max-width: 100%;
      }
    }
  </style>
  <style media='screen and (min-width:480px)'>
    .moz-text-html .mj-column-per-100 {
    width: 100% !important;
    max-width: 100%;
    }
  </style>
  <style type='text/css'>
    @media only screen and (max-width:480px) {
    table.mj-full-width-mobile {
        width: 100% !important;
    }

      td.mj-full-width-mobile {
        width: auto !important;
      }
    }
  </style>
</head>

<body style='word-spacing:normal;'>
  <div style''>
    <!--[if mso | IE]><table align='center' border='0' cellpadding='0' cellspacing='0' class'' style='width:600px;' width='600' ><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'><![endif]-->
    <div style='margin:0px auto;max-width:600px;'>
      <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='width:100%;'>
        <tbody>
          <tr>
            <td style='direction:ltr;font-size:0px;padding:20px 0;text-align:center;'>
              <!--[if mso | IE]><table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td class'' style='vertical-align:top;width:600px;' ><![endif]-->
              <div class='mj-column-per-100 mj-outlook-group-fix' style='font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;'>
                <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'>
                  <tbody>
                    <tr>
                      <td align='center' style='font-size:0px;padding:10px 25px;word-break:break-word;'>
                        <div style='font-family:sans-serif;font-size:36px;font-weight:bolder;line-height:1;text-align:center;color:#000000;'>AutoRealm</div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!--[if mso | IE]></td></tr></table><![endif]-->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--[if mso | IE]></td></tr></table><table align='center' border='0' cellpadding='0' cellspacing='0' class'' style='width:600px;' width='600' ><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'><![endif]-->
    <div style='margin:0px auto;max-width:600px;'>
      <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='width:100%;'>
        <tbody>
          <tr>
            <td style='direction:ltr;font-size:0px;padding:20px 0;padding-top:0px;text-align:center;'>
              <!--[if mso | IE]><table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td class'' style='vertical-align:top;width:600px;' ><![endif]-->
              <div class='mj-column-per-100 mj-outlook-group-fix' style='font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;'>
                <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'>
                  <tbody>
                    <tr>
                      <td align='center' style='font-size:0px;padding:10px 25px;word-break:break-word;'>
                        <div style='font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:18px;line-height:1;text-align:center;color:#000000;'>Your appointment for ${date} at ${timeslot} has been reserved! Please use this QR code as your gate pass.</div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!--[if mso | IE]></td></tr></table><![endif]-->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--[if mso | IE]></td></tr></table><table align='center' border='0' cellpadding='0' cellspacing='0' class'' style='width:600px;' width='600' ><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'><![endif]-->
    <div style='margin:0px auto;max-width:600px;'>
      <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='width:100%;'>
        <tbody>
          <tr>
            <td style='direction:ltr;font-size:0px;padding:20px 0;padding-top:0px;text-align:center;'>
              <!--[if mso | IE]><table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td class'' style='vertical-align:top;width:600px;' ><![endif]-->
              <div class='mj-column-per-100 mj-outlook-group-fix' style='font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;'>
                <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'>
                  <tbody>
                    <tr>
                      <td align='center' style='font-size:0px;padding:10px 25px;word-break:break-word;'>
                        <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='border-collapse:collapse;border-spacing:0px;'>
                          <tbody>
                            <tr>
                              <td style='width:550px;'>
                                <img height='auto' style='border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;' width='550' src='$imageUrl'  alt='appointment qr code'/>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!--[if mso | IE]></td></tr></table><![endif]-->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--[if mso | IE]></td></tr></table><![endif]-->
  </div>
</body>

</html>";
    }
}