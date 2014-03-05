var cislib = (function() {

  this.managerRequest = function(managerName, action, argObject, callback) {
    $.ajax({
      type     : "POST",
      url      : "php/" + managerName + "manager.php",
      dataType : "json",
      data     : { 
        action : action,
        args   : argObject
      },
      cache    : false,
      success  : function(result) {
        callback(result);
      },
      error    : function(a, b, c) {
        console.log('Error:');
        console.log(a);
        console.log(b);
        console.log(c);
      }
    });
  }

  this.getURLParameter = function(token) {
    var url = window.location.href,
        parameters = url.split("?")[1].split("&");
    for (var i = 0; i < parameters.length; i++) {
      var split = parameters[i].split("=");
      if (split[0] == token)
        return split[1];
    }
    return undefined;
  }

  return this;
})();