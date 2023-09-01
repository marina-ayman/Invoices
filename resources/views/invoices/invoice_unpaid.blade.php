@extends('layouts.master')
@section('title')
    <title>قائمة الفاواتير</title>
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">فواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">قائمة
                    الفواتير الغير مدفوعه</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif




    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session()->has('delete_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif


    @if (session()->has('Status_Update'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم تحديث حالة الدفع بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif

    @if (session()->has('restore_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم استعادة الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    <!-- row -->
    <div class="row">


        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">

                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <span>
                                <h4 class="card-title mg-b-0">Bordered Table</h4>
                                <p class="tx-12 tx-gray-500 mb-2">Example of Valex Bordered Table.. <a href="">Learn
                                        more</a></p>
                                <br>

                                <a href="{{ route('invoices.create') }}" class="modal-effect btn btn-sm btn-success"
                                    style="color:white"><i class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>

                            </span>
                            <img src="{{ URL::asset('assets/img/54.-Using-a-Collection-Agency-for-Unpaid-Invoices-wtllogo-980x620.png') }}"
                                alt="" height="100rem">
                        </div>
                    </div>

                    <div class="card-header pb-0">


                        {{-- 				
								@can('تصدير EXCEL')
									<a class="modal-effect btn btn-sm btn-primary" href="{{ url('export_invoices') }}"
										style="color:white"><i class="fas fa-file-download"></i>&nbsp;تصدير اكسيل</a>
								@endcan --}}

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table key-buttons text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">رقم الفاتوره</th>
                                        <th class="border-bottom-0">تاريخ المنتج</th>
                                        <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                        <th class="border-bottom-0">القسم</th>
                                        <th class="border-bottom-0">المنتج</th>
                                        <th class="border-bottom-0">مبلغ التحصيل</th>
                                        <th class="border-bottom-0"> مبلغ العمولة</th>
                                        <th class="border-bottom-0">الخصم</th>
                                        <th class="border-bottom-0">نسبة الضريبه</th>
                                        <th class="border-bottom-0">قيمة الضريبه</th>
                                        <th class="border-bottom-0">اجمالي</th>
                                        <th class="border-bottom-0"> الحالة</th>
                                     
                                        <th class="border-bottom-0"> العملية</th>
                                        <th class="border-bottom-0"> الملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($invoices as $invoice)
                                        <?php $i++; ?>

                                        <tr>
                                            <td> {{ $i }} </td>

                                            <td>{{ $invoice->invoice_number }}</td>
                                            <td>{{ $invoice->invoice_Date }}</td>
                                            <td>{{ $invoice->Due_date }}</td>
                                            <td>{{ $invoice->section->section_name }}</td>
                                            <td>{{ $invoice->product }}</td>
                                            <td>{{ $invoice->Amount_collection }}</td>
                                            <td>{{ $invoice->Amount_Commission }}</td>
                                            <td>{{ $invoice->Discount }}</td>
                                            <td>{{ $invoice->Rate_VAT }}</td>
                                            <td>{{ $invoice->Value_VAT }}</td>
                                            <td>{{ $invoice->Total }}</td>
                                            <td>
                                                @if ($invoice->Value_Status == 1)
                                                    <span
                                                        class="badge badge-pill badge-success">{{ $invoice->Status }}</span>
                                                @elseif($invoice->Value_Status == 2)
                                                    <span class="badge badge-pill badge-danger">
                                                        {{ $invoice->Status }}</span>
                                                @else
                                                    <span
                                                        class="badge badge-pill badge-warning">{{ $invoice->Status }}</span>
                                                @endif
                                            </td>

                                    
                                            <td>

                                                <div class="dropdown">
                                                    <button aria-expanded="false" aria-haspopup="true"
                                                        class="btn ripple btn-info" data-toggle="dropdown" type="button">
                                                        العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                                    <div class="dropdown-menu tx-13">
                                                        <h6
                                                            class="dropdown-header tx-uppercase tx-11 tx-bold tx-inverse tx-spacing-1">
                                                            عمليات علي الفاتوره </h6>

                                                        <a class="dropdown-item"
                                                            href="{{ url('InvoicesDetails') }}/{{ $invoice->id }}">
                                                            <i class="fas fa-eye text-success"></i>&nbsp;عرض</a>

                                                        <a class="dropdown-item"
                                                            href="{{ url('edit_invoice') }}/{{ $invoice->id }}">"
                                                            <i class="las la-pen text-info"></i>تعديل</a>



                                                        <a class="dropdown-item"
                                                            href="{{ URL::route('status_show', [$invoice->id]) }}">"
                                                            <i cclass=" text-success fas"></i>حالة الدفع</a>


                                                        <div class="dropdown-divider"></div>

                                                        <a class="dropdown-item" href="#delete_invoice"
                                                            data-id="{{ $invoice->id }}"
                                                            data-invoice_number="{{ $invoice->invoice_number }}"
                                                            href="#delete_invoice" data-toggle="modal"><i
                                                                class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                            الفاتورة</a>

                                                    </div>
                                                </div>


                                            </td>

                                            <td>{{ $invoice->note }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/div-->

            <!--div-->


        </div>
        <!-- row closed -->
    </div>

    <div class="modal" id="delete_invoice">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="invoices/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="text" name="id" id="id" value="">
                        <input class="form-control" name="invoice_number" id="invoice_number" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    {{-- delete --}}
    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
@endsection
