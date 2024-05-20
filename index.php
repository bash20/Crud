<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Use the full version of jQuery -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <title>Hello, world!</title>
  </head>

  <body>

    <div class="container">
      <form  id="userForm">
       <div class="form-group">
          <label for="Username">Name</label>
          <input type="text" class="form-control" id="Uname" name="U_name">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" class="form-control" id="email" name="Email_id" aria-describedby="emailHelp">
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
        <button type="button" class="btn btn-dark" id="save">Save</button>
      </form>
    </div>

    <div class="container">
        <h2>User Information</h2>
        <table class="table table-bordered">
            <thead>
            <div  id="response"></div>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Emailid</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="data-container"></tbody>
        </table>
    </div>

    

    <script type="text/javascript">

      $(document).ready(function () {
        function fetchData(){
              $.ajax({
                  method: 'GET',
                  url: 'info.php',
                  data : {action : 'read'},
                  dataType: 'json', 
                  success: function(response){
                      if(response.length > 0){
                          response.forEach(function(item){
                              $('#data-container').append(`<tr> <td> ${item.id} </td> <td> ${item.Uname} </td> <td> ${item.emailid} </td> <td><input class="btn btn-danger" type="button" value="Delet" name="U_delet" id="Udelet" data-id="${item.id}"> <input class="btn btn-info" type="button" value="Edit" name="U_edit" id="Uedit" data-id="${item.id}" data-name = "${item.Uname}" data-emailid = "${item.emailid}"></td> </tr>`)
                          });
                      } else {
                          console.log("No records found");
                      }
                  },
                  error: function(xhr, status, error){
                      console.error(xhr.responseText);
                  }
              });
            }
            fetchData();


            $('#submit').click(function (e) {
                e.preventDefault();
                var Uname = $('#Uname').val();
                var emailid = $('#email').val();
                if(Uname == "" || emailid == ""){
                    $('#response').html("<p class='alert alert-danger'>Fill Username or Emailid </p>");
                } else{
                $.ajax({
                    url : 'info.php',
                    method : 'POST',
                    data : {U_name : Uname, Email_id : emailid, action: 'insert'},
                    
                    success : function(data){
                        $('#response').html(data)
                        
                    }
                })
            }
        });
         

          $('#data-container').on('click','#Udelet',function(){
            
           var Uid = $(this).data('id') ;
           if(confirm("Are you sure to want to delete user?"))
            $.ajax({
                url : 'info.php',
                method : 'POST',
                data : {U_delet : Uid, action : 'delete' },
                success : function(data){
                    $('#response').html(data);
                    
                },
                error: function(xhr, status, error){
                      console.error(xhr.responseText);
                  }
            })
          })

          $('#data-container').on('click','#Uedit',function(){
            var Uid = $(this).data('id');
            var uname = $(this).data('name');
            var uemailid = $(this).data('emailid');

            $('#Uname').val(uname);
            $('#email').val(uemailid);

            $('#save').click(function(){
                $.ajax({
                    url : 'info.php',
                    method : 'POST',
                    data : {
                        id : Uid ,
                        Uname : $('#Uname').val(),
                        emailid : $('#email').val(),
                        action : 'update'
                    },
                    success :function(data){
                        $('#response').html(data);
                    }
                })
            })

            console.log(Uid, uname, uemailid);
          })
        })
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
