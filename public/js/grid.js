$(function() {

        $("#jsGrid").jsGrid({
            height: "auto",
            width: '100%',
            filtering: true,
            inserting: true,
            editing: true,
            sorting: true,
            paging: true,
            autoload: true,
            pageSize: 15,
            invalidMessage:"",
            pageButtonCount: 5,
            loadIndication : true,
            shrinkToFit: true,
            loadIndicationDelay : 1000,
            deleteConfirm: "Do you really want to delete coverage?",
            controller: {
                loadData: function(filter) {
                    return $.ajax({
                        type: "GET",
                        url: "./coverage/",
                        data: filter
                    });
                },
                insertItem: function(item) {
                    return $.ajax({
                        type: "POST",
                        url: "./coverage/",
                        data: item,
                        success : function()
                        {
                            $("#message").css("text-align","center");
                            $("#message").css("display","block");
                            $("#message").removeClass("alert alert-danger").addClass("alert alert-success");
                            $("#message").html(
                                "<p>Record Added</p>");
                                setTimeout(function() {
                                    $('#message').fadeOut('slow');
                                }, 3000);
                        },
                        error: function (thrownError) 
                        {
                             $("#message").css("text-align","center");
                             $("#message").css("display","block");
                             $("#message").html(
                             "<p>" + JSON.parse(thrownError.responseText) + "</p>");
                             setTimeout(function() {
                                $('#message').fadeOut('slow');
                            }, 3000);
                        }
                });
                },
                updateItem: function(item) {
                     return $.ajax({
                        type: "PUT",
                        url: "./coverage/",
                        data: item,
                        success : function()
                        {
                            $("#message").css("text-align","center");
                            $("#message").css("display","block");
                            $("#message").removeClass("alert alert-danger").addClass("alert alert-success");
                            $("#message").html(
                                "<p>Record Updated</p>");
                                setTimeout(function() {
                                    $('#message').fadeOut('slow');
                                }, 3000);
                        },
                        error: function (thrownError) 
                        {
                             $("#message").css("text-align","center");
                             $("#message").css("display","block");
                             $("#message").html(
                             "<p>" + JSON.parse(thrownError.responseText) + "</p>");
                             setTimeout(function() {
                                $('#message').fadeOut('slow');
                            }, 3000);
                        }
                    });
                },
                deleteItem: function(item) {
                    return $.ajax({
                        type: "DELETE",
                        url: "./coverage/",
                        data: item,
                        success : function()
                        {
                            $("#message").css("text-align","center");
                            $("#message").css("display","block");
                            $("#message").removeClass("alert alert-danger").addClass("alert alert-success");
                            $("#message").html(
                                "<p>Record Removed</p>");
                                setTimeout(function() {
                                    $('#message').fadeOut('slow');
                                }, 3000);
                        },
                        error: function (thrownError) 
                        {
                             $("#message").css("text-align","center");
                             $("#message").css("display","block");
                             $("#message").html(
                             "<p>" + JSON.parse(thrownError.responseText) + "</p>");
                             setTimeout(function() {
                                $('#message').fadeOut('slow');
                            }, 3000);
                        }
                    });
                }
            },
            fields: [
                {
                     name: "id", 
                     title:"Id",
                     width: "10%",
                     filtering: true,
                     type:"number",
                     editing:false,
                     inserting:false,
                     sorter:"number"
                },

                {
                    name: "name",
                    title: "Coverage Name",
                    width: "60%", 
                    align: "left",
                    valueType: "string",
                    filtering: true, 
                    validate: "required",
                    type: "text",
                    valueField:"Name",
                    textField:"Name",
                    items: [
                        { Name: ""},
                        { Name: "AUTO"},
                        { Name: "PROPERTY"},
                        { Name: "LEGAL EXPENSE"}
                   ],
                   validate : {
                   message: "Please select valid coverage type",
                   validator: function(value, item) {
                        if(["AUTO","PROPERTY","LEGAL EXPENSE"].includes(value.toString()))
                            return true;
                        else
                            return false;
                   }
               }
                },

                { 
                    name: "cost", 
                    title: "Cost", 
                    type: "number", 
                    width: "20%", 
                    filtering:true,
                    validate : {
                        message: "Cost cannot be null or negative",
                        validator: function(value, item) {
                                 return /^\d+$/.test(value);
                        }
                     }
                },

                { 
                    type: "control" 
                }
            ]
        });

    });