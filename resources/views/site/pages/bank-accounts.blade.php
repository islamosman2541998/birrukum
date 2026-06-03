@extends('site.app')

@section('title', @$page->trans->where('locale', $current_lang)->first()->meta_title)
@section('meta_key', @$page->trans->where('locale', $current_lang)->first()->meta_key)
@section('meta_description', @$page->trans->where('locale', $current_lang)->first()->meta_description)


@section('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block px-3">
                        <nav>
                            <ol class="breadcrumb ms-5 ms-md-0">
                                {{-- <img src="{{site_path('img/favicon.ico')}}" class="mx-2" alt=""> --}}
                                <li class="breadcrumb-item">
                                    <a href="{{ route('site.home') }}"> @lang('Home') </a>
                                </li>
                                <li class="breadcrumb-item">
                                    @lang('Page')
                                </li>
                                <li class="breadcrumb-item">
                                    <h3>الحسابات البنكية</h3>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section>
        <div class="container mt-5">

            <h2 class="text-center">
                <h3>الحسابات البنكية</h3>
            </h2>

            <div class="banks-table-wrapper">
                <table class="table banks-table">
                    <thead>
                        <tr>
                            <th>م</th>
                            <th>الأسم</th>
                            <th>رقم الحساب</th>
                            <th>IBAN</th>
                            <th>رابط البنك</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="row-number">2</td>
                            <td class="bank-name">البنك الأهلي السعودي - الرئيسي</td>
                            <td class="account-number">00114500000100</td>
                            <td class="iban">SA8910000000114500000100</td>
                            <td><span class="badge-unavailable">غير متوفر</span></td>
                            <td><span class="badge-active">فعال</span></td>
                        </tr>

                        <tr>
                            <td class="row-number">3</td>
                            <td class="bank-name">البنك الأهلي السعودي - غسيل الكلى</td>
                            <td class="account-number">00715263000107</td>
                            <td class="iban">SA3110000000715263000107</td>
                            <td><span class="badge-unavailable">غير متوفر</span></td>
                            <td><span class="badge-active">فعال</span></td>
                        </tr>

                        <tr>
                            <td class="row-number">4</td>
                            <td class="bank-name">البنك الأهلي السعودي - الزكاة</td>
                            <td class="account-number">00718097000108</td>
                            <td class="iban">SA2110000000718097000108</td>
                            <td><span class="badge-unavailable">غير متوفر</span></td>
                            <td><span class="badge-active">فعال</span></td>
                        </tr>

                        <tr>
                            <td class="row-number">5</td>
                            <td class="bank-name">البنك الأهلي السعودي - كفالة يتيم</td>
                            <td class="account-number">00723000000105</td>
                            <td class="iban">SA7110000000723000000105</td>
                            <td><span class="badge-unavailable">غير متوفر</span></td>
                            <td><span class="badge-active">فعال</span></td>
                        </tr>

                        <tr>
                            <td class="row-number">6</td>
                            <td class="bank-name">البنك الأهلي السعودي - الصدقة الجارية</td>
                            <td class="account-number">01116777000100</td>
                            <td class="iban">SA2810000001116777000100</td>
                            <td><span class="badge-unavailable">غير متوفر</span></td>
                            <td><span class="badge-active">فعال</span></td>
                        </tr>

                        <tr>
                            <td class="row-number">7</td>
                            <td class="bank-name">البنك الأهلي السعودي - القرض الحسن</td>
                            <td class="account-number">00350555000107</td>
                            <td class="iban">SA1310000000350555000107</td>
                            <td><span class="badge-unavailable">غير متوفر</span></td>
                            <td><span class="badge-active">فعال</span></td>
                        </tr>

                        <tr>
                            <td class="row-number">8</td>
                            <td class="bank-name">البنك الأهلي السعودي</td>
                            <td class="account-number">80800000022703</td>
                            <td class="iban">SA4310000080800000022703</td>
                            <td><span class="badge-unavailable">غير متوفر</span></td>
                            <td><span class="badge-active">فعال</span></td>
                        </tr>

                        <tr>
                            <td class="row-number">9</td>
                            <td class="bank-name">بنك الرياض - الرئيسي</td>
                            <td class="account-number">1040008059901</td>
                            <td class="iban">SA5520000001040008059901</td>
                            <td><span class="badge-unavailable">غير متوفر</span></td>
                            <td><span class="badge-active">فعال</span></td>
                        </tr>

                        <tr>
                            <td class="row-number">10</td>
                            <td class="bank-name">مصرف الراجحي - الرئيسي</td>
                            <td class="account-number">330608010026004</td>
                            <td class="iban">SA0280000330608010026004</td>
                            <td><span class="badge-unavailable">غير متوفر</span></td>
                            <td><span class="badge-active">فعال</span></td>
                        </tr>

                        <tr>
                            <td class="row-number">11</td>
                            <td class="bank-name">مصرف الراجحي - كفالة يتيم</td>
                            <td class="account-number">330608010000033</td>
                            <td class="iban">SA0680000330608010000033</td>
                            <td><span class="badge-unavailable">غير متوفر</span></td>
                            <td><span class="badge-active">فعال</span></td>
                        </tr>

                        <tr>
                            <td class="row-number">12</td>
                            <td class="bank-name">مصرف الراجحي - الزكاة</td>
                            <td class="account-number">330608010002609</td>
                            <td class="iban">SA0380000330608010002609</td>
                            <td><span class="badge-unavailable">غير متوفر</span></td>
                            <td><span class="badge-active">فعال</span></td>
                        </tr>

                        <tr>
                            <td class="row-number">13</td>
                            <td class="bank-name">مصرف الإنماء</td>
                            <td class="account-number">68200460901000</td>
                            <td class="iban">SA1305000068200460901000</td>
                            <td><span class="badge-unavailable">غير متوفر</span></td>
                            <td><span class="badge-active">فعال</span></td>
                        </tr>

                        <tr>
                            <td class="row-number">14</td>
                            <td class="bank-name">بنك الجزيرة</td>
                            <td class="account-number">0051428709001</td>
                            <td class="iban">SA6260000000051428709001</td>
                            <td><span class="badge-unavailable">غير متوفر</span></td>
                            <td><span class="badge-active">فعال</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </section>


@endsection

<style>
    body {
        background: #fff;
        font-family: "Tahoma", Arial, sans-serif;
        font-size: 12px;
        color: #222;
    }

    .banks-table-wrapper {
        width: 100%;
        overflow-x: auto;
        background: #fff;
    }

    .banks-table {
        width: 100%;
        min-width: 950px;
        border-collapse: collapse;
        margin: 0;
        text-align: center;
    }

    .banks-table thead th {
        background: #fff;
        color: #666;
        font-size: 11px;
        font-weight: 700;
        padding: 10px 12px;
        border-bottom: 1px solid #e5e5e5;
        white-space: nowrap;
    }

    .banks-table tbody td {
        padding: 9px 12px;
        vertical-align: middle;
        border-bottom: 1px solid #e6e6e6;
        white-space: nowrap;
        color: #222;
    }

    .banks-table tbody tr:nth-child(even) {
        background: #e9e9e9;
    }

    .banks-table tbody tr:nth-child(odd) {
        background: #fff;
    }

    .banks-table .row-number {
        font-weight: 700;
        width: 45px;
    }

    .banks-table .bank-name {
        text-align: right;
        min-width: 260px;
    }

    .banks-table .iban {
        direction: ltr;
        text-align: center;
        font-size: 12px;
    }

    .banks-table .account-number {
        direction: ltr;
        text-align: center;
        font-size: 12px;
    }

    .badge-active {
        background: #32c58b;
        color: #fff;
        border-radius: 20px;
        padding: 4px 14px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
        min-width: 52px;
    }

    .badge-unavailable {
        background: #ff7070;
        color: #fff;
        border-radius: 20px;
        padding: 4px 14px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
        min-width: 70px;
    }
</style>
