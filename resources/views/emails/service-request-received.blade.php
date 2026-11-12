<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title>New service request</title>
</head>
<body style="margin:0;padding:0;background-color:#F7F5F2;color:#1E1E22;font-family:Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#F7F5F2;">
        <tr>
            <td align="center" style="padding:28px 12px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:640px;background-color:#FFFFFF;border:1px solid #E5E1DC;">
                    <tr>
                        <td align="center" style="padding:24px;background-color:#14213D;border-bottom:5px solid #D62828;">
                            <img src="{{ $message->embed(public_path('assets/img/logo-cream-navy.png')) }}" width="200" alt="Dia Auto" style="display:block;width:200px;max-width:100%;height:auto;border:0;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px 28px 12px;">
                            <p style="margin:0 0 8px;color:#D62828;font-size:12px;font-weight:bold;letter-spacing:1.5px;text-transform:uppercase;">New customer inquiry</p>
                            <h1 style="margin:0 0 18px;color:#14213D;font-size:28px;line-height:1.2;">Service request received</h1>
                            <span style="display:inline-block;padding:8px 12px;background-color:#FFC21A;color:#14213D;font-size:13px;font-weight:bold;text-transform:uppercase;">
                                {{ ucfirst(str_replace('-', ' ', $contact->service)) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:12px 28px 24px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                @if ($contact->name)
                                    <tr>
                                        <td width="32%" style="padding:11px 12px;background-color:#F7F5F2;border-bottom:2px solid #FFFFFF;color:#14213D;font-size:13px;font-weight:bold;">Name</td>
                                        <td style="padding:11px 12px;background-color:#F7F5F2;border-bottom:2px solid #FFFFFF;font-size:14px;">{{ $contact->name }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td width="32%" style="padding:11px 12px;background-color:#F7F5F2;border-bottom:2px solid #FFFFFF;color:#14213D;font-size:13px;font-weight:bold;">Phone</td>
                                    <td style="padding:11px 12px;background-color:#F7F5F2;border-bottom:2px solid #FFFFFF;font-size:14px;"><a href="tel:{{ $contact->phone }}" style="color:#14213D;font-weight:bold;">{{ $contact->phone }}</a></td>
                                </tr>
                                <tr>
                                    <td width="32%" style="padding:11px 12px;background-color:#F7F5F2;color:#14213D;font-size:13px;font-weight:bold;">Email</td>
                                    <td style="padding:11px 12px;background-color:#F7F5F2;font-size:14px;word-break:break-word;"><a href="mailto:{{ $contact->email }}" style="color:#14213D;">{{ $contact->email }}</a></td>
                                </tr>
                            </table>

                            @if ($contact->year || $contact->make || $contact->model)
                                <h2 style="margin:26px 0 10px;color:#14213D;font-size:18px;">Vehicle</h2>
                                <p style="margin:0;padding:14px 16px;border-left:4px solid #D62828;background-color:#F7F5F2;font-size:14px;line-height:1.6;">
                                    {{ trim(implode(' ', array_filter([$contact->year, $contact->make, $contact->model]))) }}
                                </p>
                            @endif

                            <h2 style="margin:26px 0 10px;color:#14213D;font-size:18px;">Request details</h2>
                            <p style="margin:0;padding:14px 16px;border-left:4px solid #D62828;background-color:#F7F5F2;font-size:14px;line-height:1.7;">{!! nl2br(e($contact->need)) !!}</p>

                            @if ($contact->service === 'junk')
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:16px;">
                                    <tr>
                                        <td style="padding:12px;background-color:#14213D;color:#FFFFFF;font-size:13px;"><strong>Does it run?</strong><br>{{ ucfirst(str_replace('-', ' ', $contact->runs)) }}</td>
                                        <td width="12"></td>
                                        <td style="padding:12px;background-color:#14213D;color:#FFFFFF;font-size:13px;"><strong>Vehicle ZIP</strong><br>{{ $contact->zip }}</td>
                                    </tr>
                                </table>
                            @endif

                            @if ($contact->photos)
                                <h2 style="margin:28px 0 6px;color:#14213D;font-size:18px;">Customer photos</h2>
                                <p style="margin:0 0 14px;color:#555555;font-size:13px;line-height:1.6;">
                                    Photos are shown below and attached as downloadable files. Open the attachments in your email app to save them on your computer or phone.
                                </p>
                                @foreach ($contact->photos as $index => $photo)
                                    <div style="margin:0 0 18px;padding:10px;border:1px solid #E5E1DC;background-color:#F7F5F2;">
                                        <p style="margin:0 0 8px;color:#14213D;font-size:12px;font-weight:bold;">Photo {{ $index + 1 }}</p>
                                        <img src="{{ $message->embed(\Illuminate\Support\Facades\Storage::disk('local')->path($photo)) }}" alt="Customer photo {{ $index + 1 }}" style="display:block;width:auto;max-width:100%;max-height:420px;height:auto;margin:0 auto;border:0;">
                                    </div>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 28px;background-color:#14213D;border-top:4px solid #D62828;color:#F7F5F2;font-size:12px;line-height:1.6;">
                            Dia Auto &mdash; Philadelphia, PA<br>
                            Reply directly to this email to contact the customer.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
