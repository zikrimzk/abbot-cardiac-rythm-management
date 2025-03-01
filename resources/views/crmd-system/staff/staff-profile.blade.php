<!-- [ Extend Layouts ] -->
@extends('crmd-system.layouts.main')

<!-- [ Main Content ] start -->
@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript: void(0)">My Profile</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript: void(0)" class="text-uppercase">{{ Auth::user()->staff_name }}</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">My Profile</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->


        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Profile ] start -->
            <div class="col-sm-12">
               
            </div>
            <!-- [ Profile ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
@endsection
<!-- [ Main Content ] end -->