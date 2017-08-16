<div class="container-fluid">

  <div class="row">

    <div class="col-sm-12 col-md-4">

      <div class="list-group list-group-class">

      </div>

    </div>

    <div class="col-sm-12 col-md-8">

          <div class="panel panel-default">
            <div class="panel-heading">
              <span class=" text-title"></span>
              <span class="text-status">ONGOING</span>
            </div>

            <div class="panel-body panel-body-toggle">

              <div class="row">

                <div class="col-sm-2 col-md-2">

                  <div class="well well-sm">
                    <h1 class="text-center text-current"></h1>
                    <h6 class="text-center">current</h6>
                  </div>

                </div>
                <div class="col-sm-2 col-md-2">

                  <div class="well well-sm">
                    <h1 class="text-center text-last"></h1>
                    <h6 class="text-center">last</h6>
                  </div>

                </div>

                <div class="col-sm-2 col-md-2">

                  <div class="well well-sm">
                    <h1 class="text-center text-self"></h1>
                    <h6 class="text-center">self</h6>
                  </div>

                </div>

                <div class="col-md-6">

                  <div class="row">

                    <div class="col-md-6">
                      <div class="media">

                        <div class="media-body">
                          <h4 class="media-heading">Description</h4>
                          <p class="text-desc"></p>
                        </div>

                      </div>

                      <div class="media">

                        <div class="media-body">
                          <h4 class="media-heading">Restriction</h4>
                          <p class="text-rest"></p>
                        </div>

                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="media">

                        <div class="media-body">
                          <h4 class="media-heading">Requirements</h4>
                          <p class="text-req"></p>
                        </div>

                      </div>

                      <div class="media">

                        <div class="media-body">
                          <h4 class="media-heading">Venue</h4>
                          <p class="text-venue"></p>
                        </div>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

            </div>

            <div class="panel-footer footer" style="display:none">
              <div class="btn-group btn-group-justified" role="group">
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-danger btn-leave">LEAVE!</button>
                </div>
              </div>
            </div>

          </div>

          <div class="panel panel-default">

            <div class="panel-heading">
              <input type="text" id="q-search-txt" name="qsearchtxt" class="form-control" placeholder="Queue" aria-describedby="sizing-addon1">
            </br>
              <div class="btn-group btn-group-justified" role="group">
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-success btn-join">JOIN!</button>
                </div>
              </div>

            </div>

            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr class="head">
                    <th>Queue Name</th>
                    <th>Serving at</th>
                    <th>Total Queuers</th>
                    <th>Offered Seats</th>
                    <th>Description</th>
                    <th>Restriction</th>
                    <th>Requirements</th>
                    <th>Venue</th>
                  </tr>
                </thead>
                <tbody id="q-tbl-body">
                </tbody>
              </table>
            </div>

          </div>

      </div>
    </div>

  </div>
</div>
