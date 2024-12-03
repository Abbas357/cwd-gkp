<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
 
<body>
    <div style="font-family:verdana;font-size:12px;color:#555555;line-height:14pt">
        <div style="width:590px">
            <div style="background:url('https://ci3.googleusercontent.com/meips/ADKq_NbxychL5989Q-2P8WhD3zaZmExFOLHjdLeT5MrwjjlOVPOvxSpuQWNGPRMByF4vZvmtKK5fMGKQe2Os6kHKWlqPIbWmYpzaYnLq84ZyShRUP_UKf6W5Gg=s0-d-e1-ft#https://www.gstatic.com/android/market_images/email/email_top.png') no-repeat;width:100%;height:75px;display:block">
                <div style="padding-top:30px;padding-left:50px;padding-right:50px">
                    <a href="{{ route('site') }}" target="_blank">
                        <img src="{{ $logo }}" alt="C&W Logo" style="border:none">
                    </a>
                </div>
            </div>
            <div style="background:url('https://ci3.googleusercontent.com/meips/ADKq_NYzAKgKbrls_po-Au9Y4mXCjRLC2A-BxL0CEgaamcmlzrAOgtxe-ncyBvLtrwVprDSm7dTXQfZQ8xJuP85Xg889qdYDqyvbVK5MbDwuUYtwmstb_ItNbQ=s0-d-e1-ft#https://www.gstatic.com/android/market_images/email/email_mid.png') repeat-y;width:100%;display:block">
                <div style="padding-left:50px;padding-right:50px;padding-bottom:1px">
                    <div style="border-bottom:1px solid #ededed"></div>
                    Hello, <p><b>{{ $title }}</b></p>

                    <div style="background:white;padding:3%">
                        {{ $slot }}
                    </div>

                    <p>If you don't want to receive further notifications you may <a href="#" style="font-weight:bold;text-decoration:none;color:#3aaaba" target="_blank">opt out</a>.</p>Sincerely,<br>IT Cell, C&W Department
                </div>
            </div>
        </div>
        <div style="background:url('https://ci3.googleusercontent.com/meips/ADKq_NZCNbMj80PICjpr2zti8M-OJ5bQFFEq78gd8Zfb4RFxb-ZVFDcvkdDPj2LN8YQBrVZYvx5x4GIf0IqhSlooPtMkWEGDJwcW9CoONq0AqGcGMhiIlN4brA5V0w=s0-d-e1-ft#https://www.gstatic.com/android/market_images/email/email_bottom.png') no-repeat;width:100%;min-height:50px;display:block" class="adL">
            <div style="padding-left:50px;padding-right:50px"></div>
        </div>
    </div>
</body>

</html>