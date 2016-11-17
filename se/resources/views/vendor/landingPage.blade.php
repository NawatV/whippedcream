@extends('layouts.landingLayout')

@section('content')

    <!-- Services Section -->
    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Services</h2>
                    <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                <span class="fa-stack fa-4x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-map-marker fa-stack-1x fa-inverse"></i>
                </span>
                    <h4 class="service-heading">Map & information</h4>
                    <p class="text-muted">Invis provides every information you need whether you want location, Google map
                        routing, VDO, and audio file. Enjoys you trip without looking at your phone all the time!</p>
                </div>
                <div class="col-md-4">
                <span class="fa-stack fa-4x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-mobile-phone fa-stack-1x fa-inverse"></i>
                </span>
                    <h4 class="service-heading">iOS & Android</h4>
                    <p class="text-muted">Invis is accessible from both Android and iOS platform. We make sure you will be
                        comforted with our application in every ways</p>
                </div>
                <div class="col-md-4">
                <span class="fa-stack fa-4x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                </span>
                    <h4 class="service-heading">Promoting</h4>
                    <p class="text-muted">You can submit your place into Invis. We will help you to promote your place along
                        with providing you place's summary report and feedbacks from the users.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="about">
        <div class="container controlWhite">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">About</h2>
                    <br>
                    <h3 class="section-subheading text-muted controlWhite controlSizeM controlWidthAbout">Invis is a
                        brandnew mapping application that provides users
                        with information and location of nearby locations.
                        You can become both Invis's sponsor and user.
                    </h3>
                    <h3 class="section-subheading text-muted controlWhite controlSizeM controlWidthAbout">Contact us to
                        begin your sponsor program.</h3>
                </div>
            </div>
        </div>
    </section>

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Contact us</h2>
                    <h3 class="section-subheading text-muted controlWhite">We will reply you as soon as possible</h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-6">
                <span class="fa-stack fa-5x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-mail-forward fa-stack-1x fa-inverse"></i>
                </span>
                </div>
                <div class="col-md-6">
                    <div class="controlWhite">
                        <h2>E-mail</h2>
                        <h3 class="recontrolFont">admin@invisexplore.tk</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection