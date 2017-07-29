@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @include('includes.alert') 
              <!-- page start-->
              <div class="row">
                  
                  <aside class="profile-info col-lg-9">
                      <section class="panel">
                          <div class="panel-body bio-graph-info">
                              <h1>{{ $title }} ID: <span style="color:red">{{ $user->employeeID }}</span></h1>
                              <div class="row">
                                  <div class="bio-row">
                                      <p><span>First Name </span>: {{ $user->profile->first_name }}</p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Last Name </span>: {{ $user->profile->last_name }}</p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Email </span>: {{ $user->email }}</p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Birthday</span>: {{ $user->profile->birth_date }}</p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>NID </span>: {{ $user->profile->national_id }}</p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Phone </span>: {{ $user->profile->phone }}</p>
                                  </div>
                                   <div class="bio-row">
                                      <p><span>Address </span>: @if(empty($user->address->id))
                                       {{ $user->address->postal_code }}, {{ $user->address->street }}, {{ $user->address->police_station }}
                                        @else
                                         @endif </p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>City </span>: @if(!empty($user->address)){{ $user->address->city }}@else @endif</p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Country </span>: @if(!empty($user->address)){{ $user->address->country }} @else @endif</p>
                                  </div>
                              </div>
                          </div>
                      </section>
                     
                     <section>
                          <div class="row">
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <h3>Position</h3>
                                          </div>
                                          <div class="bio-desk">
                                            @if(empty($user->companyprofile->designation_id))
                                              <h3 style="color:green">{{ $user->companyprofile->designation->name }}</h3>
                                            @else
                                              ____
                                            @endif
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <h3>Rank</h3>
                                          </div>
                                          <div class="bio-desk">
                                            @if(!empty($user->companyprofile->rank_id))
                                              <h3 style="color:purple">{{ $user->companyprofile->rank->rank }}</h3>
                                            @else
                                              ____
                                            @endif
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <h3>Current Salary</h3>
                                          </div>
                                          <div class="bio-desk">
                                              

                                            @if(!empty($user->companyprofile->rank->basic))
                                              <h3 style="color:green">{{ $salary }}</h3>
                                            @else
                                              ____
                                            @endif
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <h3>Join Date</h3>
                                          </div>
                                          <div class="bio-desk">
                                            @if(!empty($user->companyprofile->join_date))
                                              <h3 style="color:green">{{ $user->companyprofile->join_date }}</h3>
                                            @else
                                              ____
                                            @endif
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <h4>Contribution</h4>
                                          </div>
                                          <div class="bio-desk">
                                            @if(!empty($user->companyprofile->contribution))
                                              <h4>  {{ $user->companyprofile->contribution }}</h4>
                                            @else
                                              ____
                                            @endif
                                          </div>
                                      </div>
                                  </div>
                              </div>

                          </div>
                      </section>
                  </aside>
                  <aside class="profile-nav col-lg-3">
                      <section class="panel">
                          <div class="user-heading round">
                              <a href="#">
                                  {{ HTML::image($user->profile->photo, 'photo', ['class'=> 'img-responsive', 'width' => '230' , 'height' => '236']) }}
                              </a>
                              <h1>{{ $user->profile->first_name }} {{ $user->profile->last_name }}</h1>
                              <p>{{ $user->email }}</p>
                          </div>


                      </section>
                  </aside>
              </div>

              <!-- page end-->



@stop


