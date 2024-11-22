<div class="footer-copyright-area">
    <style>
        .footer-copyright-area {
            background: -webkit-linear-gradient(178deg, var(--primary) 0%, var(--primary) 100%);
            background: linear-gradient(178deg, var(--primary) 0%, var(--primary) 100%);
            padding: 20px 0px;
            text-align: center;
            margin-top: 600px;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-copy-right">
                    <p>
                        @php
                            $data = App\Admin\Company::first();

                        @endphp
             © 2024 {{ $data->name }}.</a> All Rights Reserved. || Develop by
                    <u><a href="https://www.creativesoftware.com.bd" target="_blank">Creative Software Ltd</a></u>.
                    </p>
                   
                </div>
            </div>
        </div>
    </div>
</div>
