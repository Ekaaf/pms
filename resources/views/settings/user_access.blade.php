@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">User Access</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">User Access</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <form action="{{URL::to('admin/user-access')}}/{{Request::segment(3)}}" method="post" id="userAccessForm">
            {{ csrf_field() }}
            <div>
                <h4><b>Role: </b>{{$roleName}}</h4>
            </div>

            @include('layout.message')
            
            <div class="row">
                @foreach($userAccess as $access)
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-nowrap align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th colspan="2" style="text-align: center;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="parentMain{{$access['id']}}" name="menu_id[]" value="{{$access['menu_method_id']}}" <?php if(in_array($access['menu_method_id'], $menuAccess)) echo "checked"; ?> onchange="changeParent(this)">
                                                <label class="form-check-label" for="parentMain{{$access['id']}}">
                                                    {{$access['title']}}
                                                </label>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tbody{{$access['menu_method_id']}}">
                                    @if(array_key_exists("child",$access))
                                    @foreach($access['child'] as $child)
                                    <tr>
                                        <td style="vertical-align: middle;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="parent{{$child['parent']['id']}}" data-menu="{{$access['id']}}" name="menu_id[]" value="{{$child['parent']['menu_method_id']}}" <?php if(in_array($child['parent']['menu_method_id'], $menuAccess)) echo "checked"; ?> onchange="changeSub(this);">
                                                <label class="form-check-label" for="parent{{$child['parent']['id']}}">
                                                    {{$child['parent']['title']}}
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            @foreach($child['child'] as $method)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkbox1{{$method['menu_method_id']}}" value="{{$method['menu_method_id']}}" <?php if(in_array($method['menu_method_id'], $menuAccess)) echo "checked"; ?> onchange="changeMethod({{$child['parent']['id']}}, this,'submenu');">
                                                <label class="form-check-label" for="checkbox1{{$method['menu_method_id']}}">
                                                    {{$method['method_name']}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                    @if(!array_key_exists("child",$access) && is_null($access['parent_id']))
                                    @foreach($access['menu_methods'] as $menu_methods)
                                    <tr>
                                        <td colspan="2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkbox2{{$menu_methods['menu_method_id']}}" name="menu_id[]" value="{{$menu_methods['menu_method_id']}}" <?php if(in_array($menu_methods['menu_method_id'], $menuAccess)) echo "checked"; ?> onchange="checkParent({{$access['id']}},this,'menu');">
                                                <label class="form-check-label" for="checkbox2{{$menu_methods['menu_method_id']}}">
                                                    {{$menu_methods['method_name']}}
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if(checkButtonAccess('admin/user-access/{id}'))
            <div class="row">
                <div class="col-xl-12">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            @endif
        </form>
        <br>
    </div>
    <!-- end main content-->
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        // var tbody = $(document).find("tbody");
        // console.log(tbody);
        // var test = $("tbody").find('input[type=checkbox]');
        // if(test.is(":checked")){
        //     $("tbody").prev().find('input[type=checkbox]').prop("checked","true");

        // }
    });
    function changeParent(parent){
        $("#tbody"+parent.value).find('input[type=checkbox]:checked').removeAttr('checked');
    }
    function changeSub(submenu){
        var parentMain = $(submenu).data("menu");
        if(!submenu.checked) {
            $(submenu).parent().parent().parent().next().find('input[type=checkbox]:checked').removeAttr('checked');
        }
        else{
            var menuVal = submenu.value;
            $("#parentMain"+parentMain).prop("checked","true");
            $(submenu).parent().parent().parent().next().find(":checkbox[value="+menuVal+"]").prop("checked","true");
        }
    }

    function changeMethod(id, method, type= ''){
        if(!$("#parent"+id).is(":checked")){
            $(method).removeAttr('checked');
            Swal.fire(
              "Please give permission to "+type+" first",
              '',
              'error'
            );
        }
    }

    function checkParent(id, method, type= ''){
        if(!$("#parentMain"+id).is(":checked")){
            $(method).removeAttr('checked');
            Swal.fire(
              "Please give permission to "+type+" first",
              '',
              'error'
            );
        }
    }
</script>
@endsection