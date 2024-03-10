@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Menu List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Menus</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered border-secondary table-nowrap">
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Implement new UX</td>
                                    <td><span class="badge bg-primary-subtle text-primary">Backlog</span></td>
                                    <td>Lanora Sandoval</td>
                                    <td>$4,521</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- end main content-->
@endsection

@section('script')
<script type="text/javascript" src="{{URL::to('assets/custom/js/menu.js')}}"></script>
@endsection