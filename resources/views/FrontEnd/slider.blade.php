
<!-- ============= hero_area start ============== -->
{{-- <div class="hero_area">
    <div id="fawesome-carousel" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            @foreach ($slider as $data)
            <div class="item active" style="background-image:url({{ asset($data->image) }})">
                <div class="carousel-caption">
                    <div class="table">
                        <div class="cell">
                            <div class="welcome_text">
                                <h1>{{ $data->title }}</h1>
                                <div class="welcome_p">
                                    <p>{{ $data->description }}</p>
                                </div>
                                <div class="welcome_form">
                                    <form action="#">
                                        <input class="form-control" type="text" 
                                            placeholder="Enter Your Order Number">
                                        <input class="submit" type="submit" value="Track Your Order">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- carousel-inner end -->
    </div>
    <!-- /.carousel -->
</div> --}}
<!-- ============= hero_area end ============== -->
<div class="Modern-Slider">
    <!-- Item -->
    @foreach ($slider as $data)
    <div class="item">
        <div class="img-fill">
            <img src="{{ asset($data->image) }}" alt="#">
            <div class="info">
                <div>
                    <h1>{{ $data->title }}</h1>
                    <h1>{{ $data->title2 }}</h1>
                    <h5>{{ $data->description }}</h5>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- // Item -->
</div>

</section>
<!--end of header area-->