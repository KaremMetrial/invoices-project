@extends('layouts.master')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الفاتورة</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection

@section('title', ' قائمة الفواتير')

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">

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

                    <!-- row opened -->
                    <div class="row row-sm">

                        <div class="col-xl-12">
                            <!-- div -->
                            <div class="card mg-b-20" id="tabs-style2">
                                <div class="card-body">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <div class="panel panel-primary tabs-style-2">
                                                <div class=" tab-menu-heading">
                                                    <div class="tabs-menu1">
                                                        <!-- Tabs -->
                                                        <ul class="nav panel-tabs main-nav-line">
                                                            <li><a href="#tab4" class="nav-link active"
                                                                    data-toggle="tab">معلومات
                                                                    الفاتورة</a></li>
                                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات
                                                                    الدفع</a></li>
                                                            <li><a href="#tab6" class="nav-link"
                                                                    data-toggle="tab">المرفقات</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                                    <div class="tab-content">


                                                        <div class="tab-pane active" id="tab4">
                                                            <div class="table-responsive mt-15">

                                                                <table class="table table-striped"
                                                                    style="text-align:center">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th scope="row">رقم الفاتورة</th>
                                                                            <td>{{ $invoice->invoice_number }}</td>
                                                                            <th scope="row">تاريخ الاصدار</th>
                                                                            <td>{{ $invoice->invoice_date }}</td>
                                                                            <th scope="row">تاريخ الاستحقاق</th>
                                                                            <td>{{ $invoice->invoice_date }}</td>
                                                                            <th scope="row">القسم</th>
                                                                            <td>{{ $invoice->section->section_name }}</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th scope="row">المنتج</th>
                                                                            <td>{{ $invoice->product->product_name }}</td>
                                                                            <th scope="row">مبلغ التحصيل</th>
                                                                            <td>{{ $invoice->amount_collection }}</td>
                                                                            <th scope="row">مبلغ العمولة</th>
                                                                            <td>{{ $invoice->amount_commission }}</td>
                                                                            <th scope="row">الخصم</th>
                                                                            <td>{{ $invoice->discount }}</td>
                                                                        </tr>


                                                                        <tr>
                                                                            <th scope="row">نسبة الضريبة</th>
                                                                            <td>{{ $invoice->rate_vat }}</td>
                                                                            <th scope="row">قيمة الضريبة</th>
                                                                            <td>{{ $invoice->value_vat }}</td>
                                                                            <th scope="row">الاجمالي مع الضريبة</th>
                                                                            <td>{{ $invoice->total }}</td>
                                                                            <th scope="row">الحالة الحالية</th>

                                                                            @if ($invoice->value_status == 1)
                                                                                <td><span
                                                                                        class="badge badge-pill badge-success">{{ $invoice->status }}</span>
                                                                                </td>
                                                                            @elseif($invoice->value_status == 2)
                                                                                <td><span
                                                                                        class="badge badge-pill badge-danger">{{ $invoice->status }}</span>
                                                                                </td>
                                                                            @else
                                                                                <td><span
                                                                                        class="badge badge-pill badge-warning">{{ $invoice->status }}</span>
                                                                                </td>
                                                                            @endif
                                                                        </tr>

                                                                        <tr>
                                                                            <th scope="row">ملاحظات</th>
                                                                            <td>{{ $invoice->note }}</td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>

                                                        <div class="tab-pane" id="tab5">
                                                            <div class="table-responsive mt-15">
                                                                <table class="table center-aligned-table mb-0 table-hover"
                                                                    style="text-align:center">
                                                                    <thead>
                                                                        <tr class="text-dark">
                                                                            <th>#</th>
                                                                            <th>رقم الفاتورة</th>
                                                                            <th>نوع المنتج</th>
                                                                            <th>القسم</th>
                                                                            <th>حالة الدفع</th>
                                                                            <th>تاريخ الدفع </th>
                                                                            <th>ملاحظات</th>
                                                                            <th>تاريخ الاضافة </th>
                                                                            <th>المستخدم</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($invoice->invoiceDetails as $x)
                                                                            <tr>
                                                                                <td>{{ $loop->iteration }}</td>
                                                                                <td>{{ $x->invoice_number }}</td>
                                                                                <td>{{ $invoice->product->product_name }}
                                                                                </td>
                                                                                <td>{{ $invoice->section->section_name }}
                                                                                </td>
                                                                                @if ($x->value_status == 1)
                                                                                    <td><span
                                                                                            class="badge badge-pill badge-success">{{ $x->status }}</span>
                                                                                    </td>
                                                                                @elseif($x->value_status == 2)
                                                                                    <td><span
                                                                                            class="badge badge-pill badge-danger">{{ $x->status }}</span>
                                                                                    </td>
                                                                                @else
                                                                                    <td><span
                                                                                            class="badge badge-pill badge-warning">{{ $x->status }}</span>
                                                                                    </td>
                                                                                @endif
                                                                                <td>{{ $x->payment_date }}</td>
                                                                                <td>{{ $x->note }}</td>
                                                                                <td>{{ $x->created_at }}</td>
                                                                                <td>{{ $x->user }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>


                                                            </div>
                                                        </div>


                                                        <div class="tab-pane" id="tab6">
                                                            <!--المرفقات-->
                                                            <div class="card card-statistics">
                                                                <div class="card-body">
                                                                    <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg ,
                                                                        png </p>
                                                                    <h5 class="card-title">اضافة مرفقات</h5>
                                                                    <form method="post"
                                                                        action="{{ url('/InvoiceAttachments') }}"
                                                                        enctype="multipart/form-data">
                                                                        {{ csrf_field() }}
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                id="customFile" name="file_name" required>
                                                                            <input type="hidden" id="customFile"
                                                                                name="invoice_number"
                                                                                value="{{ $invoice->invoice_number }}">
                                                                            <input type="hidden" id="invoice_id"
                                                                                name="invoice_id"
                                                                                value="{{ $invoice->id }}">
                                                                            <label class="custom-file-label"
                                                                                for="customFile">حدد
                                                                                المرفق</label>
                                                                        </div><br><br>
                                                                        <button type="submit"
                                                                            class="btn btn-primary btn-sm "
                                                                            name="uploadedFile">تاكيد</button>
                                                                    </form>
                                                                </div>
                                                                <br>

                                                                <div class="table-responsive mt-15">
                                                                    <table
                                                                        class="table center-aligned-table mb-0 table table-hover"
                                                                        style="text-align:center">
                                                                        <thead>
                                                                            <tr class="text-dark">
                                                                                <th scope="col">م</th>
                                                                                <th scope="col">اسم الملف</th>
                                                                                <th scope="col">قام بالاضافة</th>
                                                                                <th scope="col">تاريخ الاضافة</th>
                                                                                <th scope="col">العمليات</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($invoice->invoiceAttachments as $attachment)
                                                                                <tr>
                                                                                    <td>{{ $loop->iteration }}</td>
                                                                                    <td>{{ $attachment->file_name }}</td>
                                                                                    <td>{{ $attachment->created_by }}</td>
                                                                                    <td>{{ $attachment->created_at }}</td>
                                                                                    <td colspan="2">

                                                                                        <a class="btn btn-outline-success btn-sm"
                                                                                            href="{{ url('invoice-attachment') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}"
                                                                                            role="button"><i
                                                                                                class="fas fa-ey     <button
                                                                                            class="btn
                                                                                                btn-outline-danger btn-sm"
                                                                                                data-toggle="modal"
                                                                                                data-file_name="{{ $attachment->file_name }}"
                                                                                                data-invoice_number="{{ $attachment->invoice_number }}"
                                                                                                data-id_file="{{ $attachment->id }}"
                                                                                                data-target="#delete_file">
                                                                                                </button>
                                                                                            </i>&nbsp;
                                                                                            عرض</a>

                                                                                        <a class="btn btn-outline-info btn-sm"
                                                                                            href="{{ url('download-invoice-attachment') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}"
                                                                                            role="button"><i
                                                                                                class="fas fa-download"></i>&nbsp;
                                                                                            تحميل</a>

                                                                                        <button
                                                                                            class="btn btn-outline-danger btn-sm"
                                                                                            data-toggle="modal"
                                                                                            data-target="#delete_file"
                                                                                            data-file_name="{{ $attachment->file_name }}"
                                                                                            data-invoice_number="{{ $attachment->invoice_number }}"
                                                                                            data-id_file="{{ $attachment->id }}">
                                                                                            حذف
                                                                                        </button>




                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /div -->
                        </div>

                    </div>
                    <!-- /row -->

                    <!-- delete -->
                    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <div class="modal-header">
                                        <h5 class="modal-title">حذف المرفق</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-center">
                                        <h6 style="color:red">هل انت متاكد من عملية حذف المرفق ؟</h6>
                                        </p>
                                        <input type="hidden" name="file_name" id="file_name">
                                        <input type="hidden" name="invoice_number" id="invoice_number">
                                        <input type="hidden" name="id_file" id="id_file">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">الغاء</button>
                                        <button type="submit" class="btn btn-danger">تاكيد</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>


                <!-- Container closed -->
            </div>
            <!-- main-content closed -->

        </div>
    </div>
    </div>
    </div>
@endsection

@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var file_name = button.data('file_name');
            var invoice_number = button.data('invoice_number');
            var id_file = button.data('id_file');

            var modal = $(this);
            modal.find('#file_name').val(file_name);
            modal.find('#invoice_number').val(invoice_number);
            modal.find('#id_file').val(id_file);

            var form = modal.find('form');
            var url = `/delete-invoice-attachment/${invoice_number}/${file_name}`;
            form.attr('action', url);
        });
    </script>
@endsection
