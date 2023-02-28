  <!-- banner area start -->
  @if (!$bannarInfo->isEmpty())
      <section class="hero-area" id="home">
          <div class="">
              <div class="hero-area-slider">

                  @foreach ($bannarInfo as $data)
                      {{-- banner image --}}
                      @if ($data->banner_type === 'image')
                          <div class="row hero-area-slide">
                              <img src="{{ URL::to('/') }}/uploads/banner/b1.jpg" alt="">
                          </div>
                      @endif
                      {{-- banner image --}}

                      {{-- banner video --}}
                      @if ($data->banner_type === 'video')
                          <div class="row hero-area-slide">
                              <div class="col-lg-8 col-md-12 order2">
                                  <div class="hero-area-content pr-50">

                                      {{-- title & description --}}
                                      <h2>{{ $data->video_title }}</h2>
                                      <p>{{ $data->video_description }}</p>
                                      {{-- title & description --}}

                                      {{-- genres --}}
                                      <ul id="primary-menu" class="slider-menu mt-30">
                                          @if (!empty($genreArr[$data->video_id]))
                                              @foreach ($genreArr[$data->video_id] as $id => $name)
                                                  <li>
                                                      <a class="theme-btn" href="#">
                                                          <i class="icofont icofont-ticket"></i>
                                                          {{ $name }}
                                                      </a>
                                                  </li>
                                              @endforeach
                                          @endif
                                      </ul>
                                      {{-- genres --}}

                                      {{-- celebrities --}}
                                      <div class="slide-cast">
                                          <h3 class="ptb-30">Celebrity</h3>

                                          @if (!$celibritiesArr[$data->video_id]->isEmpty())
                                              <?php $count = '1'; ?>
                                              @foreach ($celibritiesArr[$data->video_id] as $celebrity)
                                                  <div class="slide-cast-image">
                                                      @if (!empty($celebrity->image))
                                                          <img src="{{ URL::to('/') }}/uploads/celebrity/{{ $celebrity->image }}"
                                                              alt="{{ $celebrity->name }}"
                                                              title="{{ $celebrity->name }}" />
                                                      @else
                                                          <img src="{{ URL::to('/') }}/uploads/no.jpeg" />
                                                      @endif
                                                      <h4 class="ptb-10">{{ $celebrity->name }}</h4>
                                                  </div>

                                                  <?php
                                                  if ($count === '5') {
                                                      break;
                                                  }
                                                  $count++;
                                                  ?>
                                              @endforeach
                                          @endif
                                      </div>
                                      {{-- celebrities --}}
                                  </div>
                              </div>
                              <div class="col-lg-4 col-md-12">
                                  <div class="banner">
                                      <section id="dg-container2" class="dg-container">
                                          <a class="card-action" href="/frontend/videoshow/{{ $data->video_id }}">
                                              <i class="fa fa-play" aria-hidden="true"></i>
                                          </a>
                                          <div class="dg-wrapper">
                                              <a href="">
                                                  @if (!empty($data->thumbnail))
                                                      <img src="{{ URL::to('/') }}/uploads/video/thumbnail/{{ $data->thumbnail }}"
                                                          alt="{{ $data->video_title }}"
                                                          title="{{ $data->video_title }}" />
                                                  @else
                                                      <img src="{{ URL::to('/') }}/uploads/no.jpeg" />
                                                  @endif
                                              </a>
                                          </div>
                                      </section>
                                  </div>
                              </div>
                          </div>
                      @endif
                      {{-- banner video --}}

                  @endforeach

                  {{-- <div class="row hero-area-slide">
                      <div class="col-lg-8 col-md-12 order2">
                          <div class="hero-area-content pr-50">
                              <span> <i class="fa fa-heart"></i></a> </span>

                              <div class="top-deading">
                                  <div class="triangle-up"></div>
                                  <p> <i class="fas fa-long-arrow-alt-right"></i> Trending Now</p>
                              </div>
                              <div class="underline"></div>
                              <h2>Sherlock1</h2>
                              <p>Sherlock is a British crime television series based on Sir Arthur Conan Doyle's
                                  Sherlock
                                  Holmes detective stories. Created by Steven Moffat and
                                  Mark Gatiss, it stars Benedict Cumberbatch as Sherlock Holmes and Martin Freeman as
                                  Doctor
                                  John Watson. Thirteen episodes have been prod
                                  uced, with four three-part series airing from 2010 to 2017 and a special episode that
                                  aired on 1 January 2016. The series is set in the present da
                                  y, while the one-off special features a Victorian period fantasy resembling the
                                  original
                                  Holmes stories. Sherlock is produced by the British net
                                  w
                                  eet residence.</p>
                              <ul id="primary-menu" class="slider-menu mt-30">
                                  <li><a class="theme-btn" href="#"><i class="icofont icofont-ticket"></i> Tv
                                          Series</a>
                                  </li>
                                  <li><a class="theme-btn" href="#"><i class="icofont icofont-ticket"></i> Thriller
                                      </a>
                                  </li>
                                  <li><a class="theme-btn" href="#"><i class="icofont icofont-ticket"></i>
                                          Lorem</a>
                                  </li>
                                  <li><a class="theme-btn" href="#"><i class="icofont icofont-ticket"></i>
                                          Lorem</a>
                                  </li>
                              </ul>

                              <div class="slide-cast">
                                  <h3 class="ptb-30">Cast</h3>
                                  <div class="slide-cast-image">
                                      <img src="assets/img/cast/slide4.jpg" alt="about" />
                                      <h4 class="ptb-10">Benedict Cumberbatch</h4>
                                  </div>

                                  <div class="slide-cast-image">
                                      <img src="assets/img/cast/slide4.jpg" alt="about" />
                                      <h4 class="ptb-10">Benedict Cumberbatch</h4>
                                  </div>
                                  <div class="slide-cast-image">
                                      <img src="assets/img/cast/slide4.jpg" alt="about" />
                                      <h4 class="ptb-10">Benedict Cumberbatch</h4>
                                  </div>
                                  <div class="slide-cast-image">
                                      <img src="assets/img/cast/slide4.jpg" alt="about" />
                                      <h4 class="ptb-10">Benedict Cumberbatch</h4>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-12 order1">
                          <div class="banner">
                              <section id="dg-container" class="dg-container">
                                  <a class="card-action" href="#"><i class="fa fa-play"
                                          aria-hidden="true"></i></a>
                                  <div class="dg-wrapper">
                                      <a href="">
                                          <img src="assets/img/Rectangle 7.png">

                                      </a>
                                      <a href="">
                                          <img src="assets/img/Sherlock-2.jpg">
                                      </a>
                                      <a href="">
                                          <img src="assets/img/Sherlock-3.jpg">
                                      </a>
                                      <a href="">
                                          <img src="assets/img/Sherlock-4.jpg">
                                      </a>

                                  </div>
                                  <ol class="button" id="lightButton">
                                      <li index="0">
                                      <li index="1">
                                      <li index="2">
                                      <li index="3">
                                      <li index="4">
                                  </ol>
                                  <nav>
                                      <span class="dg-prev"></span>
                                      <span class="dg-next"></span>
                                  </nav>
                              </section>
                          </div>
                      </div>
                  </div>
                  <div class="row hero-area-slide">
                      <div class="col-lg-8 col-md-12 order2">
                          <div class="hero-area-content pr-50">
                              <span> <i class="fa fa-heart"></i></a> </span>

                              <div class="top-deading">
                                  <div class="triangle-up"></div>
                                  <p> <i class="fas fa-long-arrow-alt-right"></i> Trending Now</p>
                              </div>
                              <div class="underline"></div>
                              <h2>Sherlock3</h2>
                              <p>Sherlock is a British crime television series based on Sir Arthur Conan Doyle's
                                  Sherlock
                                  Holmes detective stories. Created by Steven Moffat and
                                  Mark Gatiss, it stars Benedict Cumberbatch as Sherlock Holmes and Martin Freeman as
                                  Doctor
                                  John Watson. Thirteen episodes have been prod
                                  uced, with four three-part series airing from 2010 to 2017 and a special episode that
                                  aired on 1 January 2016. The series is set in the present da
                                  y, while the one-off special features a Victorian period fantasy resembling the
                                  original
                                  Holmes stories. Sherlock is produced by the British net
                                  w
                                  eet residence.</p>
                              <ul id="primary-menu" class="slider-menu mt-30">
                                  <li><a class="theme-btn" href="#"><i class="icofont icofont-ticket"></i> Tv
                                          Series</a>
                                  </li>
                                  <li><a class="theme-btn" href="#"><i class="icofont icofont-ticket"></i> Thriller
                                      </a>
                                  </li>
                                  <li><a class="theme-btn" href="#"><i class="icofont icofont-ticket"></i>
                                          Lorem</a>
                                  </li>
                                  <li><a class="theme-btn" href="#"><i class="icofont icofont-ticket"></i>
                                          Lorem</a>
                                  </li>
                              </ul>

                              <div class="slide-cast">
                                  <h3 class="ptb-30">Cast</h3>
                                  <div class="slide-cast-image">
                                      <img src="assets/img/cast/slide4.jpg" alt="about" />
                                      <h4 class="ptb-10">Benedict Cumberbatch</h4>
                                  </div>

                                  <div class="slide-cast-image">
                                      <img src="assets/img/cast/slide4.jpg" alt="about" />
                                      <h4 class="ptb-10">Benedict Cumberbatch</h4>
                                  </div>
                                  <div class="slide-cast-image">
                                      <img src="assets/img/cast/slide4.jpg" alt="about" />
                                      <h4 class="ptb-10">Benedict Cumberbatch</h4>
                                  </div>
                                  <div class="slide-cast-image">
                                      <img src="assets/img/cast/slide4.jpg" alt="about" />
                                      <h4 class="ptb-10">Benedict Cumberbatch</h4>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-12 order1">
                          <div class="banner">
                              <section id="dg-container3" class="dg-container">
                                  <a class="card-action" href="#"><i class="fa fa-play"
                                          aria-hidden="true"></i></a>
                                  <div class="dg-wrapper">
                                      <a href="">
                                          <img src="assets/img/Rectangle 7.png">

                                      </a>
                                      <a href="">
                                          <img src="assets/img/Sherlock-2.jpg">
                                      </a>
                                      <a href="">
                                          <img src="assets/img/Sherlock-3.jpg">
                                      </a>
                                      <a href="">
                                          <img src="assets/img/Sherlock-4.jpg">
                                      </a>

                                  </div>
                                  <ol class="button" id="lightButton3">
                                      <li index="0">
                                      <li index="1">
                                      <li index="2">
                                      <li index="3">
                                      <li index="4">
                                  </ol>
                                  <nav>
                                      <span class="dg-prev"></span>
                                      <span class="dg-next"></span>
                                  </nav>
                              </section>
                          </div>
                      </div>
                  </div> --}}
              </div>

          </div>
      </section>
  @endif

  <!-- Banner area end -->
