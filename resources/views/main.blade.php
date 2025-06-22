@extends('layouts.app')

@section('content')

<div class="home-banner text-center text-white">
    <div class="container">
        <div class="introduction">
            <h1>Introduction to S&S</h1>
            <p>Welcome to Share and Smile (S&S), your premier online platform for spreading joy through charitable
                giving! We've curated a diverse range of impactful causes in health, education, and the environment,
                all accessible with just a few clicks. Our user-friendly interface ensures that exploring and
                selecting the causes closest to your heart is both intuitive and effortless</p>

            <p>Once you've chosen a cause to support, our secure donation process allows you to contribute with
                confidence, knowing that your personal information and payment details are safeguarded. But our
                commitment doesn't end there. With S&S, you'll have the opportunity to track the progress of the
                projects you support, witnessing firsthand the transformative power of your generosity. Join us in
                our mission to spread smiles and create positive change. Welcome to Share and Smile, where every
                donation counts toward building a brighter, more compassionate future for all.
            </p>
        </div>
        <!--/.introduction -->
    </div>
</div>
<!--/.home-banner -->


<div class="home-about">
    <div class="container">
        <!-- Messasge -->
        @if(session()->has('message'))
        <div class="alert alert-danger text-center">
            {{ session()->get('message') }}
        </div>
        @endif
        <div class="row align-items-center">
            <div class="col-lg-6 mb-3">
                <h2>About Us</h2>
                <p>Share and Smile (S&S) is a vibrant online community driven by the belief that small acts of
                    kindness can create
                    significant change. Our platform serves as a bridge between donors and charitable causes,
                    connecting individuals with
                    projects focused on health, education, and the environment worldwide.</p>

                <p>We prioritize transparency, security, and user experience, ensuring that every interaction on our
                    platform is seamless
                    and fulfilling. Whether you're a newcomer to philanthropy or a seasoned donor, S&S provides the
                    tools and resources
                    needed to support causes you care about and track the impact of your contributions in real-time.
                    Join us in spreading
                    smiles and building a brighter future. Welcome to Share and Smile – where every donation makes a
                    difference.</p>
            </div>

            <div class="col-lg-6 mb-3">
                <img src="{{ url('../images/about-share&smile.jpg') }}" alt="About Us Image" class="img-fluid">
            </div>

            <div class="col-lg-6 mb-3 order-4 order-lg-3">
                <img src="{{ url('../images/mission.jpg') }}" alt="Our Mission Image" class="img-fluid">
            </div>

            <div class="col-lg-6 mb-3 order-3 order-lg-4">
                <h2>Our Mission</h2>
                <p>At Share and Smile (S&S), we're on a mission to inspire positive change through the power of
                    giving. Our goal is to
                    empower individuals to support meaningful charitable causes and make a tangible difference in
                    the world.</p>

                <p>Through our user-friendly platform, we connect donors with diverse projects focused on improving
                    health, advancing
                    education, and protecting the environment. By prioritizing transparency, security, and community
                    engagement, we aim to
                    create a culture of generosity where every act of kindness contributes to building a brighter
                    future for all. Join us in
                    spreading smiles and making a positive impact—one donation at a time.</p>
            </div>
        </div>
    </div>
</div>
<!--/.home-about -->

<div class="charity-category">
    <div class="container">
        <h2 class="text-center mb-3">Charity Categories</h2>
        <div class="charity-list">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-12 mb-3 mb-lg-2">
                    <div class="charity-item text-center">
                        <a href="{{ route('charity_list') }}">
                            <img src="{{ url('../images/category-health.jpg') }}" alt="Health" class="img-fluid">
                            <h5>Health</h5>
                        </a>
                    </div>
                    <!--/.charity-item -->
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 mb-3 mb-lg-2">
                    <div class="charity-item text-center">
                        <a href="{{ route('charity_list') }}">
                            <img src="{{ url('../images/category-education.jpg') }}" alt="Education" class="img-fluid">
                            <h5>Education</h5>
                        </a>
                    </div>
                    <!--/.charity-item -->
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 mb-3 mb-lg-2">
                    <div class="charity-item text-center">
                        <a href="{{ route('charity_list') }}">
                            <img src="{{ url('../images/category-environment.jpg') }}" alt="Environment"
                                class="img-fluid">
                            <h5>Environment</h5>
                        </a>
                    </div>
                    <!--/.charity-item -->
                </div>
            </div>
        </div>
        <!--/.charity-list -->
    </div>
</div>
<!--/.charity-category-->

@endsection