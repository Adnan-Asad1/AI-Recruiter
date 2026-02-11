<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Hire Invitation</title>
</head>
<body style="margin:0; padding:0; font-family: 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #e0f2fe 0%, #fdf2f8 100%);">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 50px 0;">
        <tr>
            <td align="center">

                <!-- Card Container -->
                <table width="600" cellpadding="0" cellspacing="0" style="background: #ffffff; border-radius: 25px; box-shadow: 0 15px 40px rgba(0,0,0,0.1); overflow: hidden; border: 1px solid #e5e7eb;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(90deg, #4f46e5, #6366f1); padding: 40px; text-align: center; color: #fff;">
                            <h1 style="margin:0; font-size: 32px; font-weight: 800; letter-spacing: 1px;">🤖 AI Interviewer</h1>
                            <p style="margin: 8px 0 0; font-size: 18px; font-weight: 500;">Your personalized AI-powered interview awaits!</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 35px 40px; color: #374151; line-height: 1.7; font-size: 16px;">
                            <p>Hello Candidate,</p>

                            <p>We are thrilled to invite you for your <strong>AI-powered interview</strong>. Click the button below to start your journey:</p>

                            <!-- Gradient Button with Shadow & Hover -->
                            <p style="text-align: center; margin: 30px 0;">
                                <a href="{{ $link }}" target="_blank" 
                                   style="display: inline-block; background: linear-gradient(135deg, #10b981, #3b82f6); color: #fff; text-decoration: none; padding: 16px 30px; border-radius: 15px; font-weight: 700; font-size: 17px; box-shadow: 0 8px 20px rgba(0,0,0,0.15); transition: all 0.3s ease;">
                                    🚀 Start Your Interview
                                </a>
                            </p>

                            <!-- Backup Link Card -->
                            <div style="background: #f0f9ff; border-left: 4px solid #3b82f6; padding: 15px 20px; border-radius: 12px; text-align: center; font-size: 14px; color: #1e3a8a; margin-bottom: 20px;">
                                Or copy & paste this link into your browser:<br>
                                <strong style="word-break: break-all;">{{ $link }}</strong>
                            </div>

                            <p style="margin-top: 10px; font-size: 14px; color: #6b7280;">⏰ This link will remain valid for <strong>30 days</strong>.</p>

                            <p style="margin-top: 20px; font-size: 16px;">Good luck! We can't wait to see your responses. 🌟</p>
                        </td>
                    </tr>

                    <!-- Confetti Footer -->
                    <tr>
                        <td style="padding: 25px 40px; text-align: center; background: #f9fafb; font-size: 14px; color: #6b7280;">
                            🎉 Cheers,<br>
                            <strong>Smart Hire Team</strong> 🚀<br>
                            <a href="https://www.smarthire.com" target="_blank" style="color: #4f46e5; text-decoration: none;">www.airecruiter.com</a>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
