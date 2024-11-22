@extends('FrontEnd.loginMaster')
@section('title')
    Inactive Accounts
@endsection
@section('content')
    <section class="container">
        <div class="col-lg-3"></div>
        <div class="col-lg-6"
            style="margin-top:140px; margin-bottom: 73px; padding: 30px;
        border: 1px solid #4CAF50; border-radius: 1%; box-shadow: 5px 7px #888888;">
            <form action="{{ route('merchant.payment.info.save') }}" method="POST">
                @csrf
                <div class="row">
                    <p class="col-lg-12">
                        <label>Payment Type</label>
                        <Select onchange="showhideForm(this.value);" id="p_type" name="p_type" class="form-control">
                            <option value="">Select Payment Type</option>
                            <option value="Bank">Bank</option>
                            <option value="Bkash">Bkash</option>
                            <option value="Rocket">Rocket(DBBL)</option>
                            <option value="Nagad">Nagad</option>
                        </Select>
                    </p>
                    <p class="col-lg-12" id="mb_type" style="display:none">
                        <label>Account Type</label>
                        <Select name="mb_type" id="m_type" class="form-control">
                            <option value="">Select Account Type</option>
                            <option value="Agent">Agent</option>
                            <option value="Personal">Personal</option>
                        </Select>
                    <p class="col-lg-12" id="mb_number" style="display:none">
                        <label>Number</label>
                        <input type="number" name="mb_number" id="m_number" class="form-control" minlength="11"
                            maxlength="11" />
                    </p>
                    <p class="col-lg-6" id="Bank1" style="display:none">
                        <label>Bank Name</label>
                        <Select name="bank_name" id="bank_name" class="form-control">
                            <option>Select Bank</option>
                            <option value="Dutch Bangla Bank Ltd">Dutch Bangla Bank Ltd</option>
                            <option value="BRAC Bank Ltd">BRAC Bank Ltd</option>
                            <option value="AB BANK LTD">AB BANK LTD</option>
                            <option value="DHAKA BANK LTD">DHAKA BANK LTD</option>
                            <option value="EASTERN BANK LTD">EASTERN BANK LTD</option>
                            <option value="EXIM BANK LTD">EXIM BANK LTD</option>
                            <option value="IFIC BANK LTD">IFIC BANK LTD</option>
                            <option value="MERCANTILE BANK LTD">MERCANTILE BANK LTD</option>
                            <option value="MUTUAL TRUST BANK LTD">MUTUAL TRUST BANK LTD</option>
                            <option value="NATIONAL CREDIT & COMMERCE BANK LTD">NATIONAL CREDIT & COMMERCE BANK LTD</option>
                            <option value="ONE BANK LTD">ONE BANK LTD</option>
                            <option value="PRIME BANK LTD">PRIME BANK LTD</option>
                            <option value="SOCIAL ISLAMI BANK LTD">SOCIAL ISLAMI BANK LTD</option>
                            <option value="STANDARD BANK LTD">STANDARD BANK LTD</option>
                            <option value="STANDARD CHARTERED BANK LTD">STANDARD CHARTERED BANK LTD</option>
                            <option value="THE CITY BANK LTD">THE CITY BANK LTD</option>
                            <option value="PREMIER BANK LTD">PREMIER BANK LTD</option>
                            <option value="TRUST BANK LTD">TRUST BANK LTD</option>
                            <option value="UNITED COMMERCIAL BANK LTD">UNITED COMMERCIAL BANK LTD</option>
                            <option value="UTTRA BANK LTD">UTTRA BANK LTD</option>

                        </Select>
                    </p>
                    <p class="col-lg-6" id="Bank2" style="display:none">
                        <label>Branch Name</label>
                        <input type="text" name="branch_name" id="branch_name" class="form-control" />
                    </p>
                    <p class="col-lg-6" id="Bank3" style="display:none">
                        <label>Account Holder Name</label>
                        <input type="text" name="account_holder_name" id="account_holder" class="form-control" />
                    </p>
                    <p class="col-lg-6" id="Bank4" style="display:none">
                        <label>Account Type</label>
                        <select name="account_type" class="form-control" id="account_type">
                            <option value=""> Select Account Type </option>
                            <option value="CURRENT">CURRENT</option>
                            <option value="SAVING">SAVING</option>
                            <option value="AWCDI">AWCDI</option>
                            <option value="SND">SND</option>
                            <option value="STD">STD</option>
                            <option value="AWCA">AWCA</option>
                        </select>
                    </p>
                    <p class="col-lg-6" id="Bank5" style="display:none">
                        <label>Account Number</label>
                        <input type="text" name="account_number" id="account_number" class="form-control" />
                    </p>
                    <p class="col-lg-6" id="Bank6" style="display:none">
                        <label>Routing Number</label>
                        <input type="text" name="routing_number" id="routing_number" class="form-control" />
                    </p>
                </div>
                <br>
                <button type="submit" class="btn btn-success btn-block btn-sm"
                    style="text-align:center; font-size:15px;">Save</button>
            </form>
        </div>
        <div class="col-lg-3"></div>
    </section>
    <script type="text/javascript">
        function showhideForm(showform) {
            if (showform == "") {
                document.getElementById("Bank1").style.display = 'none';
                document.getElementById("Bank2").style.display = 'none';
                document.getElementById("Bank3").style.display = 'none';
                document.getElementById("Bank4").style.display = 'none';
                document.getElementById("Bank5").style.display = 'none';
                document.getElementById("Bank6").style.display = 'none';
                document.getElementById("mb_type").style.display = 'none';
                document.getElementById("mb_number").style.display = 'none';
            }
            if (showform == "Bank") {
                document.getElementById("Bank1").style.display = 'block';
                document.getElementById("Bank2").style.display = 'block';
                document.getElementById("Bank3").style.display = 'block';
                document.getElementById("Bank4").style.display = 'block';
                document.getElementById("Bank5").style.display = 'block';
                document.getElementById("Bank6").style.display = 'block';
                document.getElementById("mb_type").style.display = 'none';
                document.getElementById("mb_number").style.display = 'none';
            } else if (showform == "Bkash") {
                document.getElementById("Bank1").style.display = 'none';
                document.getElementById("Bank2").style.display = 'none';
                document.getElementById("Bank3").style.display = 'none';
                document.getElementById("Bank4").style.display = 'none';
                document.getElementById("Bank5").style.display = 'none';
                document.getElementById("Bank6").style.display = 'none';
                document.getElementById("mb_type").style.display = 'block';
                document.getElementById("mb_number").style.display = 'block';
            }
        }
    </script>
@endsection
