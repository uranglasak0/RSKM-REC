@extends('layouts.presensi')
@section('content')
    <div class="section" id="user-section">
        <div id="user-detail" style="display: flex; align-items: center;">
            <div class="avatar">
                @if (!empty(Auth::guard('karyawan')->user()->foto))
                    @php
                        $path = Storage::url('uploads/karyawan/' . Auth::guard('karyawan')->user()->foto);
                    @endphp
                    <img src="{{ $path }}" alt="avatar" class="imaged w64" style="height:60px;">
                @else
                    <img src="{{ Auth::guard('karyawan')->user()->foto ? asset('storage/uploads/karyawan/' . Auth::guard('karyawan')->user()->foto) : asset('assets/img/default.png') }}"
                        alt="Foto Profil">
                @endif
            </div>
            <div id="user-info" style="margin-top: 5px; margin-left: 50px;">
                <h2 id="user-name">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</h2>
                <span id="user-role">{{ Auth::guard('karyawan')->user()->jabatan }}</span>
            </div>
            <form id="logoutForm" action="/logout" method="POST" style="position: absolute; top: 52px; right: -10px;">
                @csrf
                <button type="submit" style="background: none; border: none; cursor: pointer;" title="Logout">
                    <ion-icon name="exit-outline" style="font-size: 30px; color: white;"></ion-icon>
                </button>
                <span
                    style="font-size: 8px; color: white; position: relative; top: 8px; right: 40px; text-align: center;">Logout</span>
            </form>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/editprofile" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/izin" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/histori" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/dashboard" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensihariini != null)
                                        @php
                                            $path = Storage::url('uploads/absensi/' . $presensihariini->foto_in);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w48">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ $presensihariini != null ? $presensihariini->jam_in : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensihariini != null && $presensihariini->jam_out != null)
                                        @php
                                            $path = Storage::url('uploads/absensi/' . $presensihariini->foto_out);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w48">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>{{ $presensihariini != null && $presensihariini->jam_out != null ? $presensihariini->jam_out : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="rekappresensi">
            <h3>Rekap Presensi Bulan {{ $namabulan[$bulanini] }} Tahun {{ $tahunini }}</h3>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height:0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top:3px; right:10px; font-size:0.6rem; z-index:999">{{ $rekappresensi->jmlhadir }}</span>
                            <ion-icon name="man-outline" style="font-size: 1.6rem;" class="text-primary mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Hadir</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height:0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top:3px; right:10px; font-size:0.6rem; z-index:999">{{ $rekapizin->jmlizin }}</span>
                            <ion-icon name="newspaper-outline" style="font-size: 1.6rem;"
                                class="text-success mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Izin</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height:0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top:3px; right:10px; font-size:0.6rem; z-index:999">{{ $rekapizin->jmlsakit }}</span>
                            <ion-icon name="medkit-outline" style="font-size: 1.6rem;"
                                class="text-warning mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Sakit</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height:0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top:3px; right:10px; font-size:0.6rem; z-index:999">{{ $rekappresensi->jmltelat }}</span>
                            <ion-icon name="alarm-outline" style="font-size: 1.6rem;"
                                class="text-danger mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Telat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($historibulanini as $d)
                            @php
                                $path = Storage::url('uploads/absensi/' . $d->foto_in);
                            @endphp
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="id-card-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</div>
                                        <span class="badge badge-success">{{ $d->jam_in }}</span>
                                        <br>
                                        <span
                                            class="badge badge-danger">{{ $presensihariini != null && $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($leaderboard as $d)
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>
                                            <b>{{ $d->nama_lengkap }}</b><br>
                                            <small class="text-muted">{{ $d->jabatan }}</small>
                                        </div>
                                        <span class="badge {{ $d->jam_in > '07:30' ? 'badge-danger' : 'badge-success' }}">
                                            {{ $d->jam_in }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection

{{-- @push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('logoutForm').addEventListener('submit', function(e) {
            e.preventDefault(); // stop submit

            Swal.fire({
                title: 'Apakah kamu yakin untuk Logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<span class="btn btn-primary m-0">Ya</span>',
                cancelButtonText: '<span class="btn btn-danger m-0">Tidak</span>',
                buttonsStyling: false, // biar custom class bootstrapnya kepakai
                reverseButtons: true // tombol "Tidak" di kiri
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // submit form kalau klik Ya
                }
            });
        });
    </script>
@endpush --}}

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('logoutForm').addEventListener('submit', function(e) {
            e.preventDefault(); 

            Swal.fire({
                title: 'Konfirmasi Logout',
                text: "Apakah kamu yakin ingin keluar?",
                icon: 'warning',
                iconColor: '#FF520D',
                showCancelButton: true,
                // Kita kunci posisinya manual:
                confirmButtonText: 'Tidak', 
                cancelButtonText: 'Ya',
                confirmButtonColor: '#d33',    // Merah untuk Tidak
                cancelButtonColor: '#FF520D', // Oranye RSKM untuk Ya
                reverseButtons: true,         // Jangan dibalik lagi
            }).then((result) => {
                // Jika result.dismiss karena klik tombol 'Ya' (yang aslinya tombol cancel)
                if (result.dismiss === Swal.DismissReason.cancel) {
                    this.submit(); 
                }
            });
        });
    </script>
@endpush