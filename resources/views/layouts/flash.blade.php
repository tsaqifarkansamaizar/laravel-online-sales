@if(session('success'))
    <div style="background:#e6f4ea;color:#137333;padding:12px 16px;border-radius:6px;margin-bottom:16px;border:1px solid #ceead6;font-size:0.95rem;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background:#fce8e6;color:#c5221f;padding:12px 16px;border-radius:6px;margin-bottom:16px;border:1px solid #fad2cf;font-size:0.95rem;">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div style="background:#fce8e6;color:#c5221f;padding:12px 16px;border-radius:6px;margin-bottom:16px;border:1px solid #fad2cf;font-size:0.95rem;">
        <ul style="margin:0;padding-left:20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

