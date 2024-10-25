<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ $title }}</title>
</head>

<body style="margin: 0; padding: 0; background-color: #ffffff;">
    <center>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
            <tr>
                <td align="center">
                    <!-- Container -->
                    <table width="600" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #e0e0e0; max-width: 600px;">
                        <!-- Header -->
                        <tr>
                            <td align="center" style="background-color: #5caad2; padding: 20px;">
                                <img src="{{ $logo }}" alt="Logo" width="100" style="margin-bottom: 20px;">
                                <h1 style="font-size: 24px; color: #ffffff; margin: 0; font-family: Arial, sans-serif;">{{ $title }}</h1>
                            </td>
                        </tr>

                        <!-- Main Content -->
                        <tr>
                            <td style="padding: 20px; font-family: Arial, sans-serif; font-size: 16px; color: #333333;">
                                {{ $slot }}
                            </td>
                        </tr>

                        <!-- Footer -->
                        <tr>
                            <td style="font-size: 12px; color: #888888; padding: 10px; border-top: 1px solid #e0e0e0; text-align: center; font-family: Arial, sans-serif; background-color: #f7f7f7;">
                                Contact us: <a href="mailto:{{ $contactEmail }}" style="color: #5caad2; text-decoration: none;">{{ $contactEmail }}</a><br>
                                <a href="{{ url('unsubscribe') }}" style="color: #5caad2; text-decoration: none;">Unsubscribe</a>
                            </td>
                        </tr>
                    </table>
                    <!-- End Container -->
                </td>
            </tr>
        </table>
    </center>
</body>

</html>
