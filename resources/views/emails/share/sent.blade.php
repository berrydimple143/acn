@extends('layouts.email') @section('content')
    <div style="display: none; font-size: 1px; line-height: 1px; 
max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: 
all; font-family: sans-serif;">
        {{ $contact->subject }}
    </div>
    <div style="display: none; font-size: 1px; line-height: 1px; 
max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: 
all; font-family: sans-serif;">
        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>
    <div style="max-width: 600px; margin: 0 auto;" 
class="email-container">
            <!--[if mso]>
            <table align="center" role="presentation" cellspacing="0" 
cellpadding="0" border="0" width="600">
            <tr>
            <td>
            <![endif]-->
	        <!-- Email Body : BEGIN -->
	        <table align="center" role="presentation" 
cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0 
auto;">
                <!-- Hero Image, Flush : BEGIN -->
                <tr>
                    <td style="background-color: #ffffff;">
                        <img 
src="{{ session('runningbg') }}" width="600" 
height="300" alt="alt_text" border="0" style="width: 100%; max-width: 
600px; height: auto; background: #dddddd; font-family: sans-serif; 
font-size: 15px; line-height: 15px; color: #555555; margin: auto;" 
class="g-img">
                    </td>
                </tr>
                <!-- Hero Image, Flush : END -->
                <!-- 1 Column Text + Button : BEGIN -->
                <tr>
                    <td style="background-color: #ffffff;">
                        <table role="presentation" cellspacing="0" 
cellpadding="0" border="0" width="100%">
                            <tr>
                                <td style="padding: 20px; font-family: 
sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                                    <h1 style="margin: 0 0 10px 0; 
font-family: sans-serif; font-size: 25px; line-height: 30px; color: 
#333333; font-weight: normal;">Dear Friend,</h1>
                                    <br/>
                                    <p style="margin: 0;">{{ 
$contact->message }}</p>
                                    <br/><br/>
                                    <p style="margin: 0;">Best 
regards,</p>
                                    <p style="margin: 0;">{{ $contact->name }}</p>
                                    <br/>
                                    <br/>
                                    <br/>                                    
                                    <p>You can email me at {{ $contact->email 
}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0 20px;">
                                    <!-- Button : BEGIN -->
                                    <table align="center" 
role="presentation" cellspacing="0" cellpadding="0" border="0" 
style="margin: auto;">
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                    <!-- Button : END -->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- 1 Column Text + Button : END -->
            </table>
            <table align="center" role="presentation" cellspacing="0" 
cellpadding="0" border="0" width="100%" style="margin: 0 auto;">
                <tr>
                    <td style="padding: 20px; font-family: sans-serif; 
font-size: 12px; line-height: 15px; text-align: center; color: 
#888888;">
                        <webversion style="color: #cccccc; 
text-decoration: underline; font-weight: bold;">All rights reserved. 
&copy; ARN</webversion>
                        <br><br>
						australianregionalnetwork.com<br><span 
class="unstyle-auto-detected-links">Alice Springs, NT, Australia<br>CEO: Garry Hill</span>
                        <br>
                    </td>
                </tr>
            </table>
        </div>
@endsection
