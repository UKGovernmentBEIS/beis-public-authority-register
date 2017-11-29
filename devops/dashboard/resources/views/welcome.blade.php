<!DOCTYPE html>


<style>
.row {
	padding: 0.5em;
}
.statcard {
  height:6em;
  text-align:center;
  padding:1em;
}
.statcard-number {
  font-size:1.3em;
}

</style>

<html lang="en">
<head>
<!-- These meta tags come first. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Primary Authority Register Dashboard</title>

<!-- Include the CSS -->
<link href="/theme-dashboard-v4/dist/toolkit-inverse.min.css" rel="stylesheet">

</head>
<body>

 <div class="row">
  <div class="col-sm-4">
    <div class="row">
      <div class="col-sm-12">
        <div class="statcard p-4" id="last_cloud_foundry_check">
        <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
        <span class="statcard-desc">Last Cloud Foundry Check (First Two App Instances)</span>
       </div>
      </div>
    </div>
   @for ($i=0; $i<2; $i++)
   <div class="row">
    <div class="col-sm-3">
     <div class="statcard p-4" id="state_{{ $i }}">
      <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
      <span class="statcard-desc">State#{{ $i }}</span>
     </div>
    </div>
    <div class="col-sm-3">
     <div class="statcard p-4" id="cpu_{{ $i }}">
      <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
      <span class="statcard-desc">CPU#{{ $i }}</span>
     </div>
    </div>
    <div class="col-sm-3">
     <div class="statcard p-4" id="memory_{{ $i }}">
      <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
      <span class="statcard-desc">Mem#{{ $i }}</span>
     </div>
    </div>
    <div class="col-sm-3">
     <div class="statcard p-4" id="disk_{{ $i }}">
      <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
      <span class="statcard-desc">Disk#{{ $i }}</span>
     </div>
    </div>
   </div>
   @endfor
  </div>

  <div class="col-sm-4">
   <div class="row">
    <div class="col-sm-12">
     <div class="statcard p-4" id="last_health_check">
      <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
      <span class="statcard-desc">Last Health Check</span>
     </div>
    </div>
   </div>
   <div class="row">
    <div class="col-sm-6">
     <div class="statcard p-4" id="responding">
      <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
      <span class="statcard-desc">Responding</span>
     </div>
    </div>
    <div class="col-sm-6">
     <div class="statcard p-4" id="last_response_time">
      <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
      <span class="statcard-desc">Last Response Time</span>
     </div>
    </div>
   </div>
   <div class="row">
       <div class="col-sm-6">
    <div class="statcard p-4" id="uptime_7_days">
     <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
     <span class="statcard-desc">Uptime (7 days)</span>
    </div>
   </div>
   <div class="col-sm-6">
    <div class="statcard p-4" id="average_response_time">
     <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
     <span class="statcard-desc">Average Response Time</span>
    </div>
   </div>

  </div>
  </div>
  <div class="col-sm-4">
   <div class="row">
    <div class="col-sm-12">
     <div class="statcard p-4" id="last_build_completed">
      <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
      <span class="statcard-desc">Last Build Completed (master branch)</span>
     </div>
    </div>
   </div>
   <div class="row">
    <div class="col-sm-6">
     <div class="statcard p-4" id="last_build_status">
      <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
      <span class="statcard-desc">Build Status</span>
     </div>
    </div>
    <div class="col-sm-6">
     <div class="statcard p-4" id="last_build_duration">
      <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
      <span class="statcard-desc">Last Build Duration</span>
     </div>
    </div>
   </div>
   <div class="row">
     <div class="col-sm-4">
      <div class="statcard p-4" id="production_version">
       <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
       <span class="statcard-desc">Production</span>
      </div>
     </div>
     <div class="col-sm-4">
      <div class="statcard p-4" id="staging_version">
       <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
       <span class="statcard-desc">Staging</span>
      </div>
     </div>
     <div class="col-sm-4">
      <div class="statcard p-4" id="assessment_version">
       <h3 class="statcard-number"><img src="images/ajax-loader.gif"></h3>
       <span class="statcard-desc">Assessment</span>
      </div>
   </div>   
  </div>
 </div>
 </div>

 <div class="row" style="height:200px;margin-bottom:1em">
  <div class="col-sm-12">
  <h3>&nbsp;Response Time History (24 hours)</h3>
  <canvas id="response_time_history"></canvas>
  </div>
 </div>
 <div class="row">
  <div class="col-sm-6">
  <h3>&nbsp;Open Pull Requests</h3>
  <table class="table" id="commit_list">
    @for ($i=0; $i<10; $i++)
      <tr>
        <td id="pull_author_{{ $i }}"></td>
        <td id="pull_title_{{ $i }}"></td>
        <td nowrap id="pull_time_{{ $i }}"></td>
      </tr>
    @endfor
  </table>
 </div>

  <div class="col-sm-6">
  <h3>&nbsp;Recent Commits</h3>
 <table class="table" id="pull_request_list">
    @for ($i=0; $i<10; $i++)
      <tr>
        <td id="commit_author_{{ $i }}"></td>
        <td id="commit_title_{{ $i }}"></td>
        <td nowrap id="commit_time_{{ $i }}"></td>
      </tr>
    @endfor
  </table>
 </div>


 

 
 </div>


 <!-- Include jQuery (required) and the JS -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
 <script src="dist/toolkit.min.js"></script>
 <script src="js/utils.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>
 <script src="node_modules/moment/min/moment.min.js"></script>

<script>

  $(document).ready(function () {

      function setUptimeColor(el, percentage) {
          var status = 'success'
          if (percentage < 0.95) {
              status = 'danger';
          } else
          if (percentage < 0.9) {
              status = 'warning';
          }
          el.removeClass('statcard-success');
          el.removeClass('statcard-warning');
          el.removeClass('statcard-danger');
          el.addClass('statcard-' + status);
      }

      function setUsageColor(el, used, total) {
          var ratio = used / total;
          var status = 'success';
          if (ratio > 0.75) {
              status = 'danger';
          } else
          if (ratio > 0.5) {
              status = 'warning';
          }
          el.removeClass('statcard-success');
          el.removeClass('statcard-warning');
          el.removeClass('statcard-danger');
          el.addClass('statcard-' + status);
      }

      function setStateColor(el, state, goodStates, warnStates) {
         var status = 'danger';
         if ($.inArray(state, goodStates) >= 0) {
            status = 'success';
         }
         if ($.inArray(state, warnStates) >= 0) {
            status = 'warning';
         }
         el.removeClass('statcard-success');
         el.removeClass('statcard-warning');
         el.removeClass('statcard-danger');
         el.addClass('statcard-' + status);
      }

      function renderCloudFoundryStats() {
        $.get("/stats/cf", function(data, status) {

           var lastChecked = moment.unix(data.received_at);
           var minutes = moment.duration(moment().diff(lastChecked)).asMinutes();
           $('#last_cloud_foundry_check > .statcard-number').html('Last checked ' + lastChecked.fromNow());
           setUsageColor($('#last_cloud_foundry_check'), minutes, 10);

           for (i=0; i<2; i++) {
             $('#state_' + i + " > .statcard-number").html(data.message[i].state == "RUNNING" ? "UP" : data[i].state);
             setStateColor($('#state_' + i), data.message[i].state, ['RUNNING'], []);

             $('#cpu_' + i + " > .statcard-number").html(parseFloat(data.message[i].stats.usage.cpu).toFixed(2) + '%');
             setUsageColor($('#cpu_' + i), data.message[i].stats.usage.cpu, data.message[i].stats.cpu_quota);

             $('#memory_' + i + " > .statcard-number").html(parseFloat(data.message[i].stats.usage.mem / 1024 / 1024).toFixed(0) + '&nbsp;Mb');
             setUsageColor($('#memory_' + i), data.message[i].stats.usage.mem, data.message[i].stats.mem_quota);

             $('#disk_' + i + " > .statcard-number").html(parseFloat(data.message[i].stats.usage.disk / 1024 / 1024).toFixed(0) + '&nbsp;Mb');
             setUsageColor($('#disk_' + i), data.message[i].stats.usage.disk, data.message[i].stats.disk_quota);
           }
        });
      }

      function renderTravisStats() {
        $.get("/stats/travis", function(data, status) {
            var lastBuildCompleted = moment(data.last_completed_build_on_master_branch.finished_at);
            var minutes = moment.duration(moment().diff(lastBuildCompleted)).asMinutes();
            $('#last_build_completed > .statcard-number').html('Last build was ' + lastBuildCompleted.fromNow());
            setUsageColor($('#last_build_completed'), minutes, 24 * 4 * 60);

            $('#last_build_status > .statcard-number').html(data.last_completed_build_on_master_branch.result == 0 ? 'Passed' : 'Failed');
            setStateColor($('#last_build_status'), data.last_completed_build_on_master_branch.result, [0], [])

            $('#last_build_duration > .statcard-number').html(moment.duration(data.last_completed_build_on_master_branch.duration * 1000).asMinutes().toFixed(2) + " mins");
            setUsageColor($('#last_build_duration'), data.last_completed_build_on_master_branch.duration, 1800)
        });
      }

      function renderGitHubStats() {
        $.get("/stats/github", function(data, status) {
            var commits = data.commits;
            for (i=0; i<commits.length && i<10; i++) {
              $('#commit_author_' + i).html(commits[i].commit.author.name)
              $('#commit_title_' + i).html(commits[i].commit.message)
              $('#commit_time_' + i).html(moment(commits[i].commit.author.date).fromNow())
            }

            var pulls = data.pull_requests;
            for (i=0; i<pulls.length && i<10; i++) {
              $('#pull_author_' + i).html(pulls[i].user.login)
              $('#pull_title_' + i).html(pulls[i].title)
              $('#pull_time_' + i).html("Updated " + moment(pulls[i].updated_at).fromNow())
            }

        });
      }

      function renderBuildVersions() {
        $.get("/stats/build_versions", function(data, status) {
           
           const envs = ['production', 'staging', 'assessment'];

           envs.forEach(function(env) {
             var id = '#' + env + '_version';
             $(id + ' > .statcard-number').html(data[env]);
             var status = 'danger';
             if (data[env].indexOf('v') == 0) {
                status = 'success';
             }
             var el = $(id);
             el.removeClass('statcard-success');
             el.removeClass('statcard-warning');
             el.removeClass('statcard-danger');
             el.addClass('statcard-' + status);
         });
        });
      }

      function renderUptimeStats() {
        $.get("/stats/uptime", function(data, status) {
            $('#responding > .statcard-number').html(data.stat == "ok" ? "Yes" : "No");
            setStateColor($('#responding'), data.stat, ['ok'], []);

            var lastHealthCheck = moment.unix(data.monitors[0].response_times[0].datetime);
            var duration = moment.duration(moment().diff(lastHealthCheck));
            var minutes = duration.asMinutes();
            $('#last_health_check > .statcard-number').html('Last checked ' + lastHealthCheck.fromNow());
            setUsageColor($('#last_health_check'), minutes, 30);

            $('#uptime_7_days > .statcard-number').html(parseFloat(data.monitors[0].custom_uptime_ratio).toFixed(2) + "%");
            setUptimeColor($('#uptime_7_days'), data.monitors[0].custom_uptime_ratio, 100);

            $('#average_response_time > .statcard-number').html(parseFloat(data.monitors[0].average_response_time).toFixed(0) + " ms");
            setUsageColor($('#average_response_time'), data.monitors[0].average_response_time, 1500);

            $('#last_response_time > .statcard-number').html(parseFloat(data.monitors[0].response_times[0].value).toFixed(0) + " ms");
            setUsageColor($('#last_response_time'), data.monitors[0].response_times[0].value, 1500);

            var response_time_data = [];
            var label_data = [];
            var last_label = '';
            for (i=0; i<data.monitors[0].response_times.length; i++) {
              response_time_data.push(data.monitors[0].response_times[i].value);

              var datetime = moment.unix(data.monitors[0].response_times[i].datetime);
              var hours = moment.duration(moment().diff(datetime)).asHours().toFixed(0);

              label_data.push(hours == last_label ? '' : hours);
              last_label = hours;
            }

            var config = {
                type: 'line',
                data: {
                    labels: label_data,
                    datasets: [{
                        label: "Response Times (ms)",
                        backgroundColor: window.chartColors.red,
                        borderColor: window.chartColors.red,
                        fill: false,
                        data: response_time_data
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    title:{
                        display:true,
                        text:'Chart.js Line Chart - Logarithmic'
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                        }],
                        yAxes: [{
                            display: true,
                        }]
                    }
                }
            };

            var ctx = document.getElementById("response_time_history").getContext("2d");
            ctx.height = 200;
            window.myLine = new Chart(ctx, config);

        });
      }

      renderGitHubStats();
      setInterval(renderGitHubStats(), 20000);

      renderBuildVersions();
      setInterval(renderBuildVersions(), 18000);

      renderTravisStats();
      setInterval(renderTravisStats, 12000);

      renderCloudFoundryStats();
      setInterval(renderCloudFoundryStats, 16000);

      renderUptimeStats();
      setInterval(renderUptimeStats, 60000);

  });
</script>

</body>
</html>

