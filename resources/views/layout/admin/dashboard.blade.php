@extends('layout.admin.index')

@section('script')

{!! HTML::script('admin/js/dashboard.js') !!}

@endsection
@section('content')
<div class="row">
        <div class="col-md-12 col-lg-8 dash-left">
          <div class="panel panel-announcement">
            <ul class="panel-options">
              <li><a><i class="fa fa-refresh"></i></a></li>
              <li><a class="panel-remove"><i class="fa fa-remove"></i></a></li>
            </ul>
            <div class="panel-heading">
              <h4 class="panel-title">Latest Announcement</h4>
            </div>
            <div class="panel-body">
              <h2>A new admin template has been released by <span class="text-primary">ThemePixels</span> with a name <span class="text-success">Quirk</span> is now live and available for purchase!</h2>
              <h4>Explore this new template and see the beauty of Quirk! <a href="#">Take a Tour!</a></h4>
            </div>
          </div><!-- panel -->

          <div class="panel panel-site-traffic">
            <div class="panel-heading">
              <ul class="panel-options">
                <li><a><i class="fa fa-refresh"></i></a></li>
              </ul>
              <h4 class="panel-title text-success">How Engaged Our Users Daily</h4>
              <p class="nomargin">Past 30 Days — Last Updated July 14, 2015</p>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-xs-6 col-sm-4">
                  <div class="pull-left">
                    <div class="icon icon ion-stats-bars"></div>
                  </div>
                  <div class="pull-left">
                    <h4 class="panel-title">Bounce Rate</h4>
                    <h3>23.30%</h3>
                    <h5 class="text-success">2.00% increased</h5>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-4">
                  <div class="pull-left">
                    <div class="icon icon ion-eye"></div>
                  </div>
                  <h4 class="panel-title">Pageviews / Visitor</h4>
                  <h3>38.10</h3>
                  <h5 class="text-danger">5.70% decreased</h5>
                </div>
                <div class="col-xs-6 col-sm-4">
                  <div class="pull-left">
                    <div class="icon icon ion-clock"></div>
                  </div>
                  <h4 class="panel-title">Time on Site</h4>
                  <h3>4:45</h3>
                  <h5 class="text-success">5.00% increased</h5>
                </div>
              </div><!-- row -->

              <div class="mb20"></div>

              <div id="basicflot" style="height: 263px"></div>

            </div><!-- panel-body -->

            <div class="table-responsive">
              <table class="table table-bordered table-default table-striped nomargin">
                <thead class="success">
                  <tr>
                    <th>Country</th>
                    <th class="text-right">% of Visitors</th>
                    <th class="text-right">Bounce Rate</th>
                    <th class="text-right">Page View</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>United States</td>
                    <td class="text-right">61%</td>
                    <td class="text-right">25.87%</td>
                    <td class="text-right">55.23</td>
                  </tr>
                  <tr>
                    <td>Canada</td>
                    <td class="text-right">13%</td>
                    <td class="text-right">23.12%</td>
                    <td class="text-right">65.00</td>
                  </tr>
                  <tr>
                    <td>Great Britain</td>
                    <td class="text-right">10%</td>
                    <td class="text-right">20.43%</td>
                    <td class="text-right">67.99</td>
                  </tr>
                  <tr>
                    <td>Philippines</td>
                    <td class="text-right">7%</td>
                    <td class="text-right">18.17%</td>
                    <td class="text-right">55.13</td>
                  </tr>
                  <tr>
                    <td>Australia</td>
                    <td class="text-right">6.03%</td>
                    <td class="text-right">17.67%</td>
                    <td class="text-right">67.05</td>
                  </tr>
                </tbody>
              </table>
            </div><!-- table-responsive -->

          </div><!-- panel -->

          <div class="row panel-statistics">
            <div class="col-sm-6">
              <div class="panel panel-updates">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-7 col-lg-8">
                      <h4 class="panel-title text-success">Products Added</h4>
                      <h3>75.7%</h3>
                      <div class="progress">
                        <div style="width: 75.7%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75.7" role="progressbar" class="progress-bar progress-bar-success">
                          <span class="sr-only">75.7% Complete (success)</span>
                        </div>
                      </div>
                      <p>Added products for this month: 75</p>
                    </div>
                    <div class="col-xs-5 col-lg-4 text-right">
                      <input type="text" value="75" class="dial-success">
                    </div>
                  </div>
                </div>
              </div><!-- panel -->
            </div><!-- col-sm-6 -->

            <div class="col-sm-6">
              <div class="panel panel-danger-full panel-updates">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-7 col-lg-8">
                      <h4 class="panel-title text-warning">Products Rejected</h4>
                      <h3>39.9%</h3>
                      <div class="progress">
                        <div style="width: 39.9%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="39.9" role="progressbar" class="progress-bar progress-bar-warning">
                          <span class="sr-only">39.9% Complete (success)</span>
                        </div>
                      </div>
                      <p>Rejected products for this month: 45</p>
                    </div>
                    <div class="col-xs-5 col-lg-4 text-right">
                      <input type="text" value="45" class="dial-warning">
                    </div>
                  </div>
                </div>
              </div><!-- panel -->
            </div><!-- col-sm-6 -->

            <div class="col-sm-6">
              <div class="panel panel-success-full panel-updates">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-7 col-lg-8">
                      <h4 class="panel-title text-success">Products Sold</h4>
                      <h3>55.4%</h3>
                      <div class="progress">
                        <div style="width: 55.4%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="55.4" role="progressbar" class="progress-bar progress-bar-info">
                          <span class="sr-only">55.4% Complete (success)</span>
                        </div>
                      </div>
                      <p>Sold products for this month: 1,203</p>
                    </div>
                    <div class="col-xs-5 col-lg-4 text-right">
                      <input type="text" value="55" class="dial-info">
                    </div>
                  </div>
                </div>
              </div><!-- panel -->
            </div><!-- col-sm-6 -->

            <div class="col-sm-6">
              <div class="panel panel-updates">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-7 col-lg-8">
                      <h4 class="panel-title text-danger">Products Returned</h4>
                      <h3>22.1%</h3>
                      <div class="progress">
                        <div style="width: 22.1%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="22.1" role="progressbar" class="progress-bar progress-bar-danger">
                          <span class="sr-only">22.1% Complete (success)</span>
                        </div>
                      </div>
                      <p>Returned products this month: 22</p>
                    </div>
                    <div class="col-xs-5 col-lg-4 text-right">
                      <input type="text" value="22" class="dial-danger">
                    </div>
                  </div>
                </div>
              </div><!-- panel -->
            </div><!-- col-sm-6 -->

          </div><!-- row -->

          <div class="row row-col-join panel-earnings">
            <div class="col-xs-3 col-sm-4 col-lg-3">
              <div class="panel">
                <ul class="panel-options">
                  <li><a><i class="glyphicon glyphicon-option-vertical"></i></a></li>
                </ul>
                <div class="panel-heading">
                  <h4 class="panel-title">Total Earnings</h4>
                </div>
                <div class="panel-body">
                  <h3 class="earning-amount">$1,543.03</h3>
                  <h4 class="earning-today">Today's Earnings</h4>

                  <ul class="list-group">
                    <li class="list-group-item">This Week <span class="pull-right">$12,320.34</span></li>
                    <li class="list-group-item">This Month <span class="pull-right">$37,520.34</span></li>
                  </ul>
                  <hr class="invisible">
                  <p>Total items sold this month: 325</p>
                </div>
              </div><!-- panel -->
            </div>
            <div class="col-xs-9 col-sm-8 col-lg-9">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Earnings Graph Overview</h4>
                </div>
                <div class="panel-body">
                  <div id="line-chart" class="body-chart"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row panel-quick-page">
            <div class="col-xs-4 col-sm-5 col-md-4 page-user">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Manage Users</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-person-stalker"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 page-products">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Manage Products</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="fa fa-shopping-cart"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-2 page-events">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Events</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-ios-calendar-outline"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-2 page-messages">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Messages</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-email"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-5 col-md-2 page-reports">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Reports</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-arrow-graph-up-right"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-2 page-statistics">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Statistics</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-ios-pulse-strong"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 page-support">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Manage Support</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-help-buoy"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-2 page-privacy">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Privacy</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-android-lock"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-2 page-settings">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Settings</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-gear-a"></i></div>
                </div>
              </div>
            </div>
          </div><!-- row -->

        </div><!-- col-md-9 -->

      </div><!-- row -->
@endsection