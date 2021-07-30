$(document).ready(function() {
  $("#submitIndex").click(function(event) {
    event.preventDefault();
    const indexName = $("#index_name").val();
    $.ajax({
      url:"/createIndex",
      data: JSON.stringify({
        indexname: indexName
      }),
      dataType: "JSON",
      method: "POST",
      contentType: "application/json",
      success: function(res) {
        if ('string' == typeof(res)) {
          res = JSON.parse(res)
        }
        if(res.error || res.status == 400) {
          alert(res.error.type);
        }
        if (res.acknowledged && res.index) {
          alert("index " + res.index + " is created");
        }
        console.log(res);
      }
    })
  })

  $("#getIndexes").click(function(event){
    event.preventDefault();
    getIndexes();
  });

  $(".allIndex").on('click', ".deleteIndex", function(event){
    event.preventDefault();
    id = this.id;
    $.ajax({
      url: "/deleteIndex",
      dataType: "JSON",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify({
        indexname: id
      }),
      success: function(res) {
        if ('string' == typeof(res)) {
          res = JSON.parse(res)
        }
        console.log(res);
        if(res.acknowledged) {
          alert("successfully deleted " + id);
        } else {
          alert(res.error.type);
        }
        getIndexes();
      }
    })
  })

  function getIndexes() {
    $.ajax({
      url:"/getIndexes",
      dataType: "JSON",
      method: "GET",
      contentType: "application/json",
      success: function(res) {
        if ('string' == typeof(res)) {
          res = JSON.parse(res)
        }
        if(res.error || res.status == 400) {
          alert(res.error.type);
        }
        if (res.acknowledged && res.index) {
          alert("index " + res.index + " is created");
        }
        console.log(res);
        if (res.length > 0) {
          columns = ""
          keys = Object.keys(res[0]);
          keys.forEach(element => {
            columns = columns + "<th>" + element + "</th>"
          });
          $(".allIndex").html("<table id='allindextable'><tbody><tr>"+ columns + "<td></td><td></td><td></td>"+"</tr></tbody></table>");
          res.forEach(element => {
            values="";
            keys.forEach(key => {
              values=values + "<td>" + element[key] +"</td>"
            })
            $("#allindextable").append(
              "<tr>"+ values +"<td>\
              <button class='moreaboutIndex' id='"+ element.index + "'>more</button>\
              </td><td>\
              <button class='deleteIndex' id='"+ element.index + "'>delete</button>\
              </td><td>\
              <button class='createDocument' id='"+ element.index + "'>add document</button>\
              </td></tr>")
          });
        }
      }
    })
  }

  $(".allIndex").on('click', ".moreaboutIndex", function(event){
    event.preventDefault();
    id = this.id;
    $.ajax({
      url: "/getDocuments",
      dataType: "JSON",
      method: "GET",
      contentType: "application/json",
      data: {
        indexname: id
      },
      success: function(res) {
        console.log(res);
        // if ('string' == typeof(res)) {
        //   res = JSON.parse(res)
        // }
        // console.log(res);
        // if(res.acknowledged) {
        //   alert("successfully deleted " + id);
        // } else {
        //   alert(res.error.type);
        // }
        // getIndexes();
      }
    })
  })

  $(".allIndex").on('click', ".createDocument", function(event){
    event.preventDefault();
    id = this.id;
    $('body').append("<div class='documentform' id='"+id+"'>\
      <span class=close>X</span>\
      <div>\
      <label>Enter brand name</label><input id='brandname'/>\
      <label>Enter model name</label><input id='modelname'/><br/>\
      <label>Enter price</label><input id='price'/>\
      <label>Enter RAM</label><input id='ram'/><br/>\
      <button type='submit' class='submitdocumentdata' id='"+id+"'>Submit</button>\
      </div> \
      </div>"
    );
  });

  $("body").on('click', ".close", function(event){
    event.preventDefault();
    $(".documentform").remove();
  });

  $("body").on('click', '.submitdocumentdata', function (event) {
    event.preventDefault();
    id = this.id;
    brand = $("#brandname").val();
    model = $("#modelname").val();
    price = $("#price").val();
    ram = $("#ram").val();
    console.log(model);
    $.ajax({
      url: "/createDocument",
      dataType: "JSON",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify({
        brand: brand,
        model: model,
        price: price,
        ram: ram,
        indexname: id,
        id: brand+model
      }),
      success: function(res) {
        // if ('string' == typeof(res)) {
        //   res = JSON.parse(res)
        // }
        console.log(res);
        // if(res.acknowledged) {
        //   alert("successfully deleted " + id);
        // } else {
        //   alert(res.error.type);
        // }
        getIndexes();
      }
    })
  })

})
