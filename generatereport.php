<!DOCTYPE html>
<html>
<head>
	<title>Sand - Inventory Management</title>
	<link rel="stylesheet" type="text/css" href="./static/bootstrap-4.5.3-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./static/style.css">
	<link rel="stylesheet" type="text/css" href="./static/toast.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="./static/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">
	<script src="https://use.fontawesome.com/0958274256.js"></script>
</head>
<?php
if( @$_GET["success"] == "msg"){
?>
<script type="text/javascript">
  $(document).ready(function() {
  myfs();
});
  </script>
  <?php
}
elseif (@$_GET["failure"] == "msg") {
?>
<script type="text/javascript">
  $(document).ready(function() {
  myff();
});
  </script>
  <?php  
}
?>
<body style="background: url(./static/wave.svg); background-repeat: no-repeat; background-size: cover;">
<div class="jumbotron jumbotron-fluid text-center">
  <div class="container">
    <h1 class="display-6" style="font-weight: 700; color: #4169e1;">SAND INVENTORY MANAGEMENT</h1>
  </div>
</div>
<div class="container-fluid side-nav">
	<div class="row">
  <div class="col-3" >
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="nav-link" id="v-pills-home-tab" href="index.php" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-plus-square" aria-hidden="true"></i> Create New Project</a>
      <a class="nav-link" id="v-pills-profile-tab"  href="existingprojects.php" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fa fa-plus" aria-hidden="true"></i> Add To Existing Project</a>
      <a class="nav-link active" id="v-pills-messages-tab" href="customerreport.php" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Go Back</a>
      <a class="nav-link" id="v-pills-settings-tab" href="driverreport.php" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-user" aria-hidden="true"></i> Driver Report</a>
    </div>
  </div>
  <div class="col-9" >
    <div class="tab-content" id="v-pills-tabContent">
      <div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
		</div>
      </div>
      <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
      <?php
      if(@$_GET["customer_name"]){
      $customername = $_GET["customer_name"];
      if(isset($_POST['d1'])) $d1 = $_POST['d1'];
      if(isset($_POST['d2'])) $d2 = $_POST['d2'];
        ?>
        <div class="container-fluid" style="height:80vh;overflow-y: auto;">
          <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <h4 class="text-center"><b>Generate Report - Select project to generate report</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4">
              <form  class="example" action="generatereport.php?customer_name=<?php echo $customername?>" method="POST" style="display: block">
                <span>From Date</span>
                <input  class="textbox-n" type="date"   id="d1" name="d1" required value="<?php echo (isset($d1)) ? $d1: '2021-07-09'?>">
                <span>To Date</span>
                <input placeholder="To date" class="textbox-n" type="date"   id="d2" name="d2" required="" value="<?php echo (isset($d2)) ? $d2: date("Y-m-d")?>">&emsp;
            </div>
            <dir class="col-lg-4">
              <button id="ds" class="btn btn-primary" name="dsearch" type="submit"><b><i class="fa fa-search"></i> SEARCH</b></button>
              </form>
            </dir>
            <div class="col-lg-4" style="display: flex">
              <a href='#' id="fpdf" style='margin-top:3.5em' target='_blank'><button class="btn btn-primary"><b>GENERATE PDF</b> <i class='fa fa-file' ></i></button></a>
            </div>
          </div>
        </div>
          <div class="row" style="padding: inherit;">
            <?php
              $servername = "localhost";
              $username = "root";
              $password = "";
              $dbname = "sandinventory";

              // Create connection
              $conn = mysqli_connect($servername, $username, $password, $dbname);
              // Check connection
              if (!$conn) {
                  die("Connection failed: " . mysqli_connect_error());
              }
              if(isset($_POST['dsearch'])){
              $q = $_POST['d1'];
              $q1 = $_POST['d2'];
              $sql = "SELECT * FROM records WHERE date BETWEEN '$q' AND '$q1' and customer_name = '".$customername."' ";
              $result = mysqli_query($conn, $sql);
              $r=mysqli_num_rows($result);
              if (mysqli_num_rows($result) > 0) {
                  echo "<table class='table table-striped table-responsive-md'>
                        <thead>
                          <tr>
                            <th class='tg-0lax text-center' style='background: royalblue; color: white;' colspan='8'>".$customername."</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr style='background: #a2d9ff;'>
                            <td class='tg-0lax'><b>Id</b></td>
                            <td class='tg-0lax'><b>Date</b></td>
                            <td class='tg-0lax'><b>Vehicle No</b></td>
                            <td class='tg-0lax'><b>Bill No</b></td>
                            <td class='tg-0lax'><b>Material</b></td>
                            <td class='tg-0lax'><b>Unit</b></td>
                            <td class='tg-0lax'><b>Rate</b></td>
                            <td class='tg-0lax'><b>Location No</b></td>
                          </tr>";
                  while($row = mysqli_fetch_assoc($result)) {
                      echo "  <tr>
                              <td class='tg-0lax'><b>".$row["id"]."</b></td>
                              <td class='tg-0lax'><b>".$row["date"]."</b></td>
                              <td class='tg-0lax'><b>".$row["vehicle_no"]."</b></td>
                              <td class='tg-0lax'><b>".$row["bill_no"]."</b></td>
                              <td class='tg-0lax'><b>".$row["material"]."</b></td>
                              <td class='tg-0lax'><b>".$row["unit"]."</b></td>
                              <td class='tg-0lax'><b>".$row["rate"]."</b></td>
                              <td class='tg-0lax'><b>".$row["location_no"]."</b></td>
                            </tr>";
                    }
                    echo "</tbody>
                          </table>";
                  }
              else {
                  ?>
                  <center><div id="nof"><h1 ><font color="black">No projects available </font> 
                 </h1></div></center>
                  <?php
              }

              $sql1 = "SELECT DISTINCT unit,material FROM records WHERE  date BETWEEN '$q' AND '$q1' and customer_name = '".$customername."'";
              $result1 = mysqli_query($conn, $sql1);
              if (mysqli_num_rows($result1) > 0) {
                  echo "<table class='table table-striped table-responsive-md text-center'>
                        <thead>
                          <tr style='background: royalblue; color: white;'>
                            <th class='tg-0lax text-center'>Material</th>
                            <th class='tg-0lax text-center'>unit*rate</th>
                            <th class='tg-0lax text-center'>Total rate</th>
                            <th class='tg-0lax text-center'>Disel</th>
                            <th class='tg-0lax text-center'>Driver</th>
                            <th class='tg-0lax text-center'>Rent</th>
                            <th class='tg-0lax text-center'>Total</th>
                          </tr>
                        </thead>
                        <tbody";
                  while($row1 = mysqli_fetch_assoc($result1)) {
                      echo "<tr><td class='tg-0lax'><b>".$row1["material"]."</b></td>
                              <td class='tg-0lax'><b>".$row1["unit"]."*".($row1["material"] == "msand" ? '2300' : '1700')."</b></td>";
                      $totalrate = $row1["unit"]*($row1["material"] == "msand" ? '2300' : '1700');
                      echo "<td class='tg-0lax'><b>".$totalrate."</b></td>
                              <td class='tg-0lax'><b>1300</b></td>
                              <td class='tg-0lax'><b>700</b></td>
                              <td class='tg-0lax'><b>".($row1["material"] == "msand" ? '2000' : '1800')."</b></td>";
                      $total = $totalrate+1300+700+($row1["material"] == "msand" ? '2000' : '1800');
                      echo "<td class='tg-0lax'><b>".$total."</b></td>
                            </tr>";
                    }
                    echo "</tbody>
                          </table>";
                  }

}
              else{
              $sql = "SELECT * FROM records WHERE customer_name = '".$customername."'";
              $result = mysqli_query($conn, $sql);
              $r=mysqli_num_rows($result);
              if (mysqli_num_rows($result) > 0) {
                  echo "<table class='table table-striped table-responsive-md'>
                        <thead>
                          <tr>
                            <th class='tg-0lax text-center' style='background: royalblue; color: white;' colspan='8'>".$customername."</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr style='background: #a2d9ff;'>
                            <td class='tg-0lax'><b>Id</b></td>
                            <td class='tg-0lax'><b>Date</b></td>
                            <td class='tg-0lax'><b>Vehicle No</b></td>
                            <td class='tg-0lax'><b>Bill No</b></td>
                            <td class='tg-0lax'><b>Material</b></td>
                            <td class='tg-0lax'><b>Unit</b></td>
                            <td class='tg-0lax'><b>Rate</b></td>
                            <td class='tg-0lax'><b>Location No</b></td>
                          </tr>";
                  while($row = mysqli_fetch_assoc($result)) {
                      echo "  <tr>
                              <td class='tg-0lax'><b>".$row["id"]."</b></td>
                              <td class='tg-0lax'><b>".$row["date"]."</b></td>
                              <td class='tg-0lax'><b>".$row["vehicle_no"]."</b></td>
                              <td class='tg-0lax'><b>".$row["bill_no"]."</b></td>
                              <td class='tg-0lax'><b>".$row["material"]."</b></td>
                              <td class='tg-0lax'><b>".$row["unit"]."</b></td>
                              <td class='tg-0lax'><b>".$row["rate"]."</b></td>
                              <td class='tg-0lax'><b>".$row["location_no"]."</b></td>
                            </tr>";
                    }
                    echo "</tbody>
                          </table>";
                  }
              else {
                  ?>
                  <center><div id="nof"><h1 ><font color="black">No projects available </font> 
                 </h1></div></center>
                  <?php
              }

              $sql1 = "SELECT DISTINCT unit,material FROM records WHERE customer_name = '".$customername."'";
              $result1 = mysqli_query($conn, $sql1);
              if (mysqli_num_rows($result1) > 0) {
                  echo "<table class='table table-striped table-responsive-md text-center'>
                        <thead>
                          <tr style='background: royalblue; color: white;'>
                            <th class='tg-0lax text-center'>Material</th>
                            <th class='tg-0lax text-center'>unit*rate</th>
                            <th class='tg-0lax text-center'>Total rate</th>
                            <th class='tg-0lax text-center'>Disel</th>
                            <th class='tg-0lax text-center'>Driver</th>
                            <th class='tg-0lax text-center'>Rent</th>
                            <th class='tg-0lax text-center'>Total</th>
                          </tr>
                        </thead>
                        <tbody";
                  while($row1 = mysqli_fetch_assoc($result1)) {
                      echo "<tr><td class='tg-0lax'><b>".$row1["material"]."</b></td>
                              <td class='tg-0lax'><b>".$row1["unit"]."*".($row1["material"] == "msand" ? '2300' : '1700')."</b></td>";
                      $totalrate = $row1["unit"]*($row1["material"] == "msand" ? '2300' : '1700');
                      echo "<td class='tg-0lax'><b>".$totalrate."</b></td>
                              <td class='tg-0lax'><b>1300</b></td>
                              <td class='tg-0lax'><b>700</b></td>
                              <td class='tg-0lax'><b>".($row1["material"] == "msand" ? '2000' : '1800')."</b></td>";
                      $total = $totalrate+1300+700+($row1["material"] == "msand" ? '2000' : '1800');
                      echo "<td class='tg-0lax'><b>".$total."</b></td>
                            </tr>";
                    }
                    echo "</tbody>
                          </table>";
                  }
                }
            }
              ?>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
      <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
    </div>
  </div>
</div>
</div>
<!-- <script type="text/javascript">
	var date = new Date();
    document.getElementById("d2").value = date.getFullYear() + '-' +((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate()));
</script> -->
<script type="text/javascript">
  $(document).ready(function(){
    var d1 = document.getElementById("d1").value;
    var d2 = document.getElementById("d2").value;    
    var url = "generatecustomerreport.php?customer_name="+'<?php echo $customername ?>'+"&fromdate="+d1+"&todate="+d2+"";
    document.getElementById("fpdf").href = url;
  });
</script>
<script id="rendered-js">
(function (define) {
  define(['jquery'], function ($) {
    return function () {
      var $container;
      var listener;
      var toastId = 0;
      var toastType = {
        error: 'error',
        info: 'info',
        success: 'success',
        warning: 'warning',
        classic: 'classic' };


      var toastr = {
        clear: clear,
        remove: remove,
        error: error,
        getContainer: getContainer,
        info: info,
        options: {},
        subscribe: subscribe,
        success: success,
        version: '2.1.2',
        warning: warning,
        classic: classic };


      var previousToast;

      return toastr;

      ////////////////

      function error(message, title, optionsOverride) {
        return notify({
          type: toastType.error,
          iconClass: getOptions().iconClasses.error,
          message: message,
          optionsOverride: optionsOverride,
          title: title });

      }

      function getContainer(options, create) {
        if (!options) {options = getOptions();}
        $container = $('#' + options.containerId);
        if ($container.length) {
          return $container;
        }
        if (create) {
          $container = createContainer(options);
        }
        return $container;
      }

      function info(message, title, optionsOverride) {
        return notify({
          type: toastType.info,
          iconClass: getOptions().iconClasses.info,
          message: message,
          optionsOverride: optionsOverride,
          title: title });

      }
      function classic(message, title, optionsOverride) {
        return notify({
          type: toastType.classic,
          iconClass: getOptions().iconClasses.classic,
          message: message,
          optionsOverride: optionsOverride,
          title: title });

      }

      function subscribe(callback) {
        listener = callback;
      }

      function success(message, title, optionsOverride) {
        return notify({
          type: toastType.success,
          iconClass: getOptions().iconClasses.success,
          message: message,
          optionsOverride: optionsOverride,
          title: title });

      }

      function warning(message, title, optionsOverride) {
        return notify({
          type: toastType.warning,
          iconClass: getOptions().iconClasses.warning,
          message: message,
          optionsOverride: optionsOverride,
          title: title });

      }

      function clear($toastElement, clearOptions) {
        var options = getOptions();
        if (!$container) {getContainer(options);}
        if (!clearToast($toastElement, options, clearOptions)) {
          clearContainer(options);
        }
      }

      function remove($toastElement) {
        var options = getOptions();
        if (!$container) {getContainer(options);}
        if ($toastElement && $(':focus', $toastElement).length === 0) {
          removeToast($toastElement);
          return;
        }
        if ($container.children().length) {
          $container.remove();
        }
      }

      // internal functions

      function clearContainer(options) {
        var toastsToClear = $container.children();
        for (var i = toastsToClear.length - 1; i >= 0; i--) {
          clearToast($(toastsToClear[i]), options);
        }
      }

      function clearToast($toastElement, options, clearOptions) {
        var force = clearOptions && clearOptions.force ? clearOptions.force : false;
        if ($toastElement && (force || $(':focus', $toastElement).length === 0)) {
          $toastElement[options.hideMethod]({
            duration: options.hideDuration,
            easing: options.hideEasing,
            complete: function () {removeToast($toastElement);} });

          return true;
        }
        return false;
      }

      function createContainer(options) {
        $container = $('<div/>').
        attr('id', options.containerId).
        addClass(options.positionClass).
        attr('aria-live', 'polite').
        attr('role', 'alert');

        $container.appendTo($(options.target));
        return $container;
      }

      function getDefaults() {
        return {
          tapToDismiss: true,
          toastClass: 'toast',
          containerId: 'toast-container',
          debug: false,

          showMethod: 'fadeIn', //fadeIn, slideDown, and show are built into jQuery
          showDuration: 600,
          showEasing: 'swing', //swing and linear are built into jQuery
          onShown: undefined,
          hideMethod: 'fadeOut',
          hideDuration: 1600,
          hideEasing: 'swing',
          onHidden: undefined,
          closeMethod: false,
          closeDuration: false,
          closeEasing: false,

          extendedTimeOut: 1600,
          iconClasses: {
            error: 'toast-error',
            info: 'toast-info',
            success: 'toast-success',
            warning: 'toast-warning',
            classic: 'toast-classic' },

          iconClass: 'toast-info',
          positionClass: 'toast-top-right',
          timeOut: 5000, // Set timeOut and extendedTimeOut to 0 to make it sticky
          titleClass: 'toast-title',
          messageClass: 'toast-message',
          escapeHtml: false,
          target: 'body',
          closeHtml: '<button type="button">&times;</button>',
          newestOnTop: true,
          preventDuplicates: false,
          progressBar: false };

      }

      function publish(args) {
        if (!listener) {return;}
        listener(args);
      }

      function notify(map) {
        var options = getOptions();
        var iconClass = map.iconClass || options.iconClass;

        if (typeof map.optionsOverride !== 'undefined') {
          options = $.extend(options, map.optionsOverride);
          iconClass = map.optionsOverride.iconClass || iconClass;
        }

        if (shouldExit(options, map)) {return;}

        toastId++;

        $container = getContainer(options, true);

        var intervalId = null;
        var $toastElement = $('<div/>');
        var $titleElement = $('<div/>');
        var $messageElement = $('<div/>');
        var $progressElement = $('<div/>');
        var $closeElement = $(options.closeHtml);
        var progressBar = {
          intervalId: null,
          hideEta: null,
          maxHideTime: null };

        var response = {
          toastId: toastId,
          state: 'visible',
          startTime: new Date(),
          options: options,
          map: map };


        personalizeToast();

        displayToast();

        handleEvents();

        publish(response);

        if (options.debug && console) {
          console.log(response);
        }

        return $toastElement;

        function escapeHtml(source) {
          if (source == null)
          source = "";

          return new String(source).
          replace(/&/g, '&amp;').
          replace(/"/g, '&quot;').
          replace(/'/g, '&#39;').
          replace(/</g, '&lt;').
          replace(/>/g, '&gt;');
        }

        function personalizeToast() {
          setIcon();
          setTitle();
          setMessage();
          setCloseButton();
          setProgressBar();
          setSequence();
        }

        function handleEvents() {
          $toastElement.hover(stickAround, delayedHideToast);
          if (!options.onclick && options.tapToDismiss) {
            $toastElement.click(hideToast);
          }

          if (options.closeButton && $closeElement) {
            $closeElement.click(function (event) {
              if (event.stopPropagation) {
                event.stopPropagation();
              } else if (event.cancelBubble !== undefined && event.cancelBubble !== true) {
                event.cancelBubble = true;
              }
              hideToast(true);
            });
          }

          if (options.onclick) {
            $toastElement.click(function (event) {
              options.onclick(event);
              hideToast();
            });
          }
        }

        function displayToast() {
          $toastElement.hide();

          $toastElement[options.showMethod](
          { duration: options.showDuration, easing: options.showEasing, complete: options.onShown });


          if (options.timeOut > 0) {
            intervalId = setTimeout(hideToast, options.timeOut);
            progressBar.maxHideTime = parseFloat(options.timeOut);
            progressBar.hideEta = new Date().getTime() + progressBar.maxHideTime;
            if (options.progressBar) {
              progressBar.intervalId = setInterval(updateProgress, 10);
            }
          }
        }

        function setIcon() {
          if (map.iconClass) {
            $toastElement.addClass(options.toastClass).addClass(iconClass);
          }
        }

        function setSequence() {
          if (options.newestOnTop) {
            $container.prepend($toastElement);
          } else {
            $container.append($toastElement);
          }
        }

        function setTitle() {
          if (map.title) {
            $titleElement.append(!options.escapeHtml ? map.title : escapeHtml(map.title)).addClass(options.titleClass);
            $toastElement.append($titleElement);
          }
        }

        function setMessage() {
          if (map.message) {
            $messageElement.append(!options.escapeHtml ? map.message : escapeHtml(map.message)).addClass(options.messageClass);
            $toastElement.append($messageElement);
          }
        }

        function setCloseButton() {
          if (options.closeButton) {
            $closeElement.addClass('toast-close-button').attr('role', 'button');
            $toastElement.prepend($closeElement);
          }
        }

        function setProgressBar() {
          if (options.progressBar) {
            $progressElement.addClass('toast-progress');
            $toastElement.prepend($progressElement);
          }
        }

        function shouldExit(options, map) {
          if (options.preventDuplicates) {
            if (map.message === previousToast) {
              return true;
            } else {
              previousToast = map.message;
            }
          }
          return false;
        }

        function hideToast(override) {
          var method = override && options.closeMethod !== false ? options.closeMethod : options.hideMethod;
          var duration = override && options.closeDuration !== false ?
          options.closeDuration : options.hideDuration;
          var easing = override && options.closeEasing !== false ? options.closeEasing : options.hideEasing;
          if ($(':focus', $toastElement).length && !override) {
            return;
          }
          clearTimeout(progressBar.intervalId);
          return $toastElement[method]({
            duration: duration,
            easing: easing,
            complete: function () {
              removeToast($toastElement);
              if (options.onHidden && response.state !== 'hidden') {
                options.onHidden();
              }
              response.state = 'hidden';
              response.endTime = new Date();
              publish(response);
            } });

        }

        function delayedHideToast() {
          if (options.timeOut > 0 || options.extendedTimeOut > 0) {
            intervalId = setTimeout(hideToast, options.extendedTimeOut);
            progressBar.maxHideTime = parseFloat(options.extendedTimeOut);
            progressBar.hideEta = new Date().getTime() + progressBar.maxHideTime;
          }
        }

        function stickAround() {
          clearTimeout(intervalId);
          progressBar.hideEta = 0;
          $toastElement.stop(true, true)[options.showMethod](
          { duration: options.showDuration, easing: options.showEasing });

        }

        function updateProgress() {
          var percentage = (progressBar.hideEta - new Date().getTime()) / progressBar.maxHideTime * 100;
          $progressElement.width(percentage + '%');
        }
      }

      function getOptions() {
        return $.extend({}, getDefaults(), toastr.options);
      }

      function removeToast($toastElement) {
        if (!$container) {$container = getContainer();}
        if ($toastElement.is(':visible')) {
          return;
        }
        $toastElement.remove();
        $toastElement = null;
        if ($container.children().length === 0) {
          $container.remove();
          previousToast = undefined;
        }
      }

    }();
  });
})(typeof define === 'function' && define.amd ? define : function (deps, factory) {
  if (typeof module !== 'undefined' && module.exports) {//Node
    module.exports = factory(require('jquery'));
  } else {
    window.toastr = factory(window.jQuery);
  }
});
function myfs(){
    toastr["success"]("Record Created!"," Success");
}
function myff(){
    toastr["error"]("Error in adding stock!, please try again","Error");
}
function rcheck() {
  if (document.getElementById('addd').value == 0 || document.getElementById('adddes').value == 0 || document.getElementById('addn').value == 0 || document.getElementById('addr').value == 0 || document.getElementById('addc').value == 0 || document.getElementById('addt').value == 0 || document.getElementById('adds').value == 0 || document.getElementById('addf').value == 0 || document.getElementById('addsn').value == 0 || document.getElementById('addesr').value == 0 || document.getElementById('addstate').value == 0 || document.getElementById('addl').value == 0 ) {
    toastr["error"]("Please fill all fields first!", "Error");
    return false;
  }
   else if(!(document.getElementById('se').value.match("[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$")))
  {
          toastr["error"]("Invaid email &emsp;&emsp;(Format:example@gmail.com)", "Error");
          return false;
  }

   else if( ! ((document.getElementById('sp').value ) == (document.getElementById('scp').value)) )
  {
          toastr["error"]("password and confirm password should be same", "Error");
          return false;
  }
  return true;
}

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "10000",
  "hideDuration": "10000",
  "timeOut": "10000",
  "extendedTimeOut": "10000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut" };
          //# sourceURL=pen.js
        </script>
</body>
</html>