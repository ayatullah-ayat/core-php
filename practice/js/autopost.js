$("#target").change(function (event) {
  $("#spinner").show();

  var txt = $("#message").val();
  console.log("Posting.....");

  $.post("autoecho.php", { val: txt }, function (data) {
    window.console && console.log(data);

    $("#result").empty().append(data);
    $("#spinner").hide();
  });
});
