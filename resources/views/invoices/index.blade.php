@extends('layouts.master')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    قائمة الفواتير</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('title', ' قائمة الفواتير')

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-sm-6 col-md-4 col-xl-3">
                            <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-block">
                                اضافة فاتورة
                            </a>
                        </div>
                        <div class="col">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('Add'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('Add') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('error') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <strong>{{ $error }}</strong><br>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap"
                            data-page-length='50'style="text-align: center">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                    <th class="wd-20p border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="wd-15p border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="wd-15p border-bottom-0">المنتج</th>
                                    <th class="wd-15p border-bottom-0">القسم</th>
                                    <th class="wd-15p border-bottom-0">الخصم</th>
                                    <th class="wd-15p border-bottom-0">نسبة الضريبة</th>
                                    <th class="wd-15p border-bottom-0">قيمة الضريبة</th>
                                    <th class="wd-15p border-bottom-0">الاجمالى</th>
                                    <th class="wd-15p border-bottom-0">الحالة</th>
                                    <th class="wd-15p border-bottom-0">ملاحظات</th>
                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product->product_name }}</td>
                                        <td><a
                                                href="{{ route('invoices.show', $invoice->id) }}">{{ $invoice->section->section_name }}</a>
                                        </td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->rate_vat }}</td>
                                        <td>{{ $invoice->value_vat }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>
                                            @switch($invoice->value_status)
                                                @case(2)
                                                    <span class="badge badge-pill badge-danger">غير مدفوعة</span>
                                                @break

                                                @case(1)
                                                    <span class="badge badge-pill badge-success">مدفوعة</span>
                                                @break

                                                @default
                                                    <span class="badge badge-pill badge-warning">مدفوعة جزئيا</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $invoice->note }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    <a class="dropdown-item "
                                                        href=" {{ route('invoices.edit', $invoice->id) }}"">تعديل
                                                        الفاتورة</a>
                                                    <a class="dropdown-item" href="" data-effect="effect-scale" data-toggle="modal"
                                                        data-target="#deleteModal" data-id="{{ $invoice->id }}"
                                                        data-invoice_name="{{ $invoice->invoice_number }}" title="حذف">
                                                        <i class="text-danger fas fa-trash-alt">
                                                        حذف الفاتورة
                                                        </i>
                                                    </a>
                                                </div>
                                            </div>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">تأكيد الحذف</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body text-center">
                        <i class="fas fa-exclamation-triangle text-danger fa-3x mb-3"></i>
                        <h4>هل أنت متأكد من حذف الفاتورة؟</h4>
                        <p class="invoice-name-display mb-0 text-muted"></p>
                    </div>
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-danger px-4">حذف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const invoiceName = button.data('invoice_number');
            const modal = $(this);

            modal.find('.invoice-name-display').text(invoiceName);
            modal.find('#deleteForm').attr('action', `/invoices/${id}`);
        });

        // Add loading state on delete
        $('#deleteForm').on('submit', function() {
            $(this).find('button[type="submit"]')
                .html('<span class="spinner-border spinner-border-sm mx-2"></span>جاري الحذف...')
                .attr('disabled', true);
        });
    </script>
    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const invoiceName = button.data('invoice_name');
            const modal = $(this);

            modal.find('.invoice-name-display').text(invoiceName);
            modal.find('#deleteForm').attr('action', `/invoices/${id}`);
        });

        // Add loading state on delete
        $('#deleteForm').on('submit', function() {
            $(this).find('button[type="submit"]')
                .html('<span class="spinner-border spinner-border-sm mx-2"></span>جاري الحذف...')
                .attr('disabled', true);
        });
    </script>
@endsection
