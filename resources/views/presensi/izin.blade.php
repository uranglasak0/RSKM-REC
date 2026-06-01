@extends('layouts.presensi')
@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="/dashboard" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin Atau Sakit</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top:70px">
        <div class="col">
            @php
                $messagesuccess = Session::get('success');
                $messageerror = Session::get('error');
            @endphp
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ $messagesuccess }}
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    {{ $messageerror }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
    <div class="col">
        <ul class="listview image-listview">
            @foreach ($dataizin as $d)
                <li>
                    <div class="item">
                        <div class="in">
                            <div>
                                <b>{{ date('d-m-Y', strtotime($d->tgl_izin)) }} ({{ $d->status == 's' ? 'Sakit' : 'Izin' }})</b><br>
                                <small class="text-muted">{{ $d->keterangan }}</small>
                            </div>
                            
                            <span>
                                @if ($d->status_approved == 0)
                                    <span class="badge bg-warning">Pending</span>
                                @elseif ($d->status_approved == 1)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    </div>
</div>
    <div class="fab-button bottom-right" style="margin-bottom:70px">
        <a href="/presensi/buatizin" class="fab">
            <ion-icon name="add-outline"></ion-icon>
        </a>
    </div>
@endsection
