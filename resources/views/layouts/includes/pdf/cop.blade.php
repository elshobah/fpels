<div class="cop-container">
    <div class="cop-left">
        <img style="max-width: 10%" src="{{ asset("https://ezzat.ac.id/wp-content/uploads/2020/11/ezzat-logo-main-png.png") }}" class="logo" alt="Logo Sekolah">
        {{-- <img src="{{ asset("storage/$setting->logo") }}" class="logo" alt="Logo Sekolah"> --}}
    </div>
    <div class="cop-right">
        <h1 class="school-name">{{ $setting->name }}</h1>
        <div class="school-detail">
            <h4 style="text-transform: capitalize;">
                {{ $setting->address }}
            </h4>
            <h4>Tlp: {{ $setting->phone }} Fax: {{ $setting->fax }} Email: {{ $setting->email }}</h4>
        </div>
    </div>
</div>
<div class="line-1"></div>
