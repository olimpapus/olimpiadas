// form login
$(document).ready(function() {
    $('#loginForm').on('submit', function(event) {
        event.preventDefault();
        
        let formData = $("#loginForm").serialize();

        $.ajax({
            type: "POST",
            url: 'php/session.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    window.location.href = "profile";
                }else{
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                    
                }
            }
        });

    });
});

// form register
$(document).ready(function() {
    $('#formRegister').on('submit', function(event) {
        event.preventDefault();
        
        let formData = $("#formRegister").serialize();

        $.ajax({
            type: "POST",
            url: 'php/register.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    window.location.href = "profile";
                }else{
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                    
                }
            }
        });

    });
});




//cargar user header
loadLogUser();
function loadLogUser() {
    $.ajax({ 
        url: "php/logUser.php",
        type: "POST",
    })
    .done(function(data) {
        
        $("#logUser").html(data);
    });
}
loadLogUserAdmin();
function loadLogUserAdmin() {
    $.ajax({ 
        url: "php/logUserAdmin.php",
        type: "POST",
    })
    .done(function(data) {
        
        $("#admin").html(data);
    });
}
function log() {
    $.ajax({
        type: "POST",
        url: "php/config/log.php",
        success: function(response) {
            if (response.success) {
               
            }else{
                window.location.href = "login";
            }
            
        }
    });
};
function permissionsAdmin() {
    $.ajax({
        type: "POST",
        url: "php/config/permissionsAdmin.php",
        success: function(response) {
            if (response.success) {
               
            }else{
                window.location.href = "login";
            }
            
        }
    });
};



//--------------------------------------------------PROFILE--------------------------------------------------//

//cargar usuario
function loadUser() {
    
    $.ajax({ 
        url: "php/user.php",
        type: "POST"
    })
    .done(function(data) {
        let datos = JSON.parse(data);
        if (datos.length > 0) {
            let dato = datos[0];
            $(".id").val(dato.id);
            $(".name").val(dato.name);
            $(".user").val(dato.user);
            $(".email").val(dato.email);
            $(".permissions").val(dato.permissions);
        }
    });
};

//form editar mis datos
$(document).ready(function() {
    $('#fromMyData').on('submit', function(event) {
        event.preventDefault();
        
        let formData = $("#fromMyData").serialize();

        $.ajax({
            type: "POST",
            url: 'php/crud/uploadDataUser.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                    let  form = document.getElementById("fromMyData");
                    form.reset();
                    loadUser();
                }else{
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                }
            }
        });

    });
});


//----------------------------------------------------------------ORDERS--------------------------------------------------------------------//

function loadOrders() {
    $.ajax({ 
        url: "php/load/loadOrders.php",
        type: "POST"
    })
    .done(function(data) {
        let datos = JSON.parse(data);
        let dataa = "";
        
        datos.forEach(dato => {
            console.log(dato.shopping);
            dataa += `
            <tr class="pointer rowTD">
                <td> ${dato.name} </td>
                <td><label class="badge badge-${dato.status}">${dato.status}</label></td>
                <td> ${dato.date} </td>
                <td>
                    <table class="table" style="background-color: transparent;">
                        <thead>
                            <tr>
                                <th>titulo</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${dato.shopping} 
                        </tbody>
                    </table>
                </td>
            </tr>`;
        });
        $("#orders").html(dataa);
    })
};

function loadOrdersHistory() {
    $.ajax({ 
        url: "php/load/loadOrdersHistory.php",
        type: "POST"
    })
    .done(function(data) {
        let datos = JSON.parse(data);
        let dataa = "";
        
        datos.forEach(dato => {
            console.log(dato.shopping);
            dataa += `
            <tr class="pointer rowTD">
                <td> ${dato.name} </td>
                <td><label class="badge badge-${dato.status}">${dato.status}</label></td>
                <td> ${dato.date} </td>
                <td>
                    <table class="table" style="background-color: transparent;">
                        <thead>
                            <tr>
                                <th>titulo</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${dato.shopping} 
                        </tbody>
                    </table>
                </td>
                <td>
                    ${dato.btn} 
                </td>
            </tr>`;
        });
        $("#ordersHistory").html(dataa);
    })
};

$('#orders').on('submit', '.deleteOrder', function(event) {
    event.preventDefault();
    let formData = $(this).serialize();
    $.ajax({
        type: "POST",
        url: 'php/crud/deleteOrder.php',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                loadOrders();
            }else{
                $('#alert').html(response.message);
                $('#alert').css('top', '25px');
                setTimeout(function(){
                    $('#alert').css('top', '-500px');
                }, 4000);
            }
        }
    });
});
$('#ordersHistory').on('submit', '.deleteOrder', function(event) {
    event.preventDefault();
    let formData = $(this).serialize();
    $.ajax({
        type: "POST",
        url: 'php/crud/deleteOrder.php',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                loadOrders();
                loadOrdersHistory();
            }else{
                $('#alert').html(response.message);
                $('#alert').css('top', '25px');
                setTimeout(function(){
                    $('#alert').css('top', '-500px');
                }, 4000);
            }
        }
    });
});
$('#ordersHistory').on('submit', '.formUpdateOrders', function(event) {
    event.preventDefault();
    let formData = $(this).serialize();
    $.ajax({
        type: "POST",
        url: 'php/crud/updateOrders.php',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                loadOrdersHistory();
                $('#alert').html(response.message);
                $('#alert').css('top', '25px');
                setTimeout(function(){
                    $('#alert').css('top', '-500px');
                }, 4000);
            }else{
                loadOrdersHistory();
                $('#alert').html(response.message);
                $('#alert').css('top', '25px');
                setTimeout(function(){
                    $('#alert').css('top', '-500px');
                }, 4000);
            }
        }
    });
});






//--------------------------------------------------CART--------------------------------------------------//

function loadCart() {

    $.ajax({ 
        url: "php/load/loadCart.php",
        type: "POST"
    })
    .done(function(data) {
        let datos = JSON.parse(data);
        let dataa = "";

        datos.forEach(dato => {
            dataa += `
            <tr class="pointer rowTD">
                <td> ${dato.title} </td>
                <td> ${dato.description} </td>
                <td> ${dato.price} </td>
                <td>
                    <div class="d-flex">
                        <form class="formDeleteCart" method="post">
                            <input type="hidden" name="id" value="${dato.id}">
                            <input type="hidden" name="cant" value="1">
                            <button type="submit" class="btn btn-danger btn-icon-text">
                                -
                            </button>
                        </form>
                        <input type="number" name="cant" style="width: 50px;margin-left: 5px;margin-right: 5px;text-align: center;" value="${dato.cant}" min="1" disabled>
                        <form class="formUploadCart" method="post">
                            <input type="hidden" name="id" value="${dato.id}">
                            <input type="hidden" name="cant" value="1">
                            <button type="submit" class="btn btn-danger btn-icon-text">
                                +
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            `;
        });
        $("#cart").html(dataa); 
    })
};

function loadTotalCart() {
    $.ajax({ 
        url: "php/load/loadTotalCart.php",
        type: "POST"
    })
    .done(function(data) {
        $("#totalCart").html(data); 
    })
};

$(document).ready(function() {
    $('#cart').on('submit', '.formUploadCart', function(event) {
        event.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: 'php/cart/uploadCart.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    loadCart();
                    loadTotalCart();
                }else{
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                }
            }
        });
    });
    loadCart();
    loadTotalCart();
});

$(document).ready(function() {
    $('#cart').on('submit', '.formDeleteCart', function(event) {
        event.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: 'php/cart/deleteCart.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    loadCart();
                    loadTotalCart();
                }else{
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                }
            }
        });
    });
    loadCart();
    loadTotalCart();
});








//--------------------------------------------------STORE--------------------------------------------------//

$(document).ready(function() {
    $("#filters").on("change click", function() {
        let filters = $("#filters").val();
        let currentUrl = window.location.href.split('?')[0]; 
        let newUrl = currentUrl + "?filters=" + filters;
        history.pushState(null, '', newUrl); 
        loadStore();
    });
    loadStore();
});

function loadStore() {
    
    let Url = new URL(window.location.href);
    let filters = Url.searchParams.get('filters');

    $.ajax({
        url: "php/load/loadStore.php",
        type: "POST",
        data: { filters: filters }
    })
    .done(function(data) {
        let datos = JSON.parse(data);
        let dataa = "";

        datos.forEach(dato => {
            dataa += `
            <tr class="pointer rowTD">
                <td>${dato.title}</td>
                <td>${dato.description}</td>
                <td>${dato.category}</td>
                <td>${dato.price}</td>
                <td>${dato.stock}</td>
                <td>
                    <form class="formUploadCart" method="post">
                        <input type="hidden" name="id" value="${dato.id}">
                        <input type="hidden" name="cant" value="1">
                        <button type="submit" class="btn btn-primary btn-icon-text" data-id="${dato.id}">
                            <i class="mdi mdi-cart-outline btn-icon-prepend"></i>Agregar al carrito 
                        </button>
                    </form>
                </td>
            </tr>
            `;
        });
        $("#store").html(dataa);
    });
}

function filters() {
    $.ajax({
        type: "POST",
        url: "php/filters/filters.php",
        success: function(response) {
            $('#filters').html(response);
        }
    });
};

$(document).ready(function() {
    $('#store').on('submit', '.formUploadCart', function(event) {
        event.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: 'php/cart/uploadCart.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                
                if (response.success) {
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                    let  form = document.getElementById("formUploadCart");
                    form.reset();
                }else{
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                    let  form = document.getElementById("formUploadCart");
                    form.reset();
                }
            }
        });
    });
    loadStore();
});
function filters() {
    $.ajax({
        type: "POST",
        url: "php/filters/filters.php",
        success: function(response) {
            $('#filters').html(response);
            
        }
    });
};


//--------------------------------------------------PRODUCTOS--------------------------------------------------//

//cargar productos
function loadProducts() {

    $.ajax({ 
        url: "php/load/loadProducts.php",
        type: "POST"
    })
    .done(function(data) {
        let datos = JSON.parse(data);
        let dataa = "";

        datos.forEach(dato => {
            dataa += `
            <tr class="pointer rowTD" data-bs-toggle="modal" data-bs-target="#updateProduct" data-id="${dato.id}">
                <td> ${dato.title} </td>
                <td> ${dato.description} </td>
                <td> ${dato.category} </td>
                <td> ${dato.price} </td>
                <td> ${dato.stock} </td>
                <td>
                    <button type="button" class="btn btn-danger btn-icon-text" data-bs-toggle="modal" data-bs-target="#deleteProduct" data-id="${dato.id}">
                        <i class="mdi mdi-delete-forever btn-icon-prepend"></i>Eliminar 
                    </button>
                </td>
            </tr>
            `;
        });
        $("#products").html(dataa); 
    })
};

//form subir productos
$(document).ready(function() {
    $('#formUploadProduct').on('submit', function(event) {
        event.preventDefault();
        
        let formData = $("#formUploadProduct").serialize();

        $.ajax({
            type: "POST",
            url: 'php/crud/uploadProduct.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                    loadProducts();
                    let  form = document.getElementById("formUploadProduct");
                    form.reset();
                }else{
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                }
                
            }
        });

    });
});

//modal editar productos
$(document).ready(function(){  
    let updateProduct = document.getElementById('updateProduct')
    updateProduct.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget
        let id = button.getAttribute('data-id')
        $.ajax({
            url: 'php/modal/modalProduct.php',
            method: 'POST',
            data: { id: id }
        })
        .done(function(data) {
            let datos = JSON.parse(data);
            if (datos.length > 0) {
                let dato = datos[0];
                $("#formUpdateProduct input[name='id']").val(dato.id);
                $("#formUpdateProduct input[name='title']").val(dato.title);
                $("#formUpdateProduct input[name='description']").val(dato.description);
                $("#formUpdateProduct input[name='category']").val(dato.category);
                $("#formUpdateProduct input[name='price']").val(dato.price);
                $("#formUpdateProduct input[name='stock']").val(dato.stock);
            }
        });
    })
    updateProduct.addEventListener('hidden.bs.modal', event => {
        let  form = document.getElementById("formUpdateProduct");
        form.reset();
            $('.alert').empty();
            $('.alert').css('top', '-1000px');
        })
});

//form actualizar productos
$(document).ready(function() {
    $('#formUpdateProduct').on('submit', function(event) {
        event.preventDefault();
        
        let formData = $("#formUpdateProduct").serialize();

        $.ajax({
            type: "POST",
            url: 'php/crud/updateProduct.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                    loadProducts();
                }else{
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                }
                
            }
        });

    });
});

//modal eliminar productos
$(document).ready(function(){  
    let deleteProduct = document.getElementById('deleteProduct')
    deleteProduct.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget
        let id = button.getAttribute('data-id')
        $("#formDeleteProduct input[name='id']").val(id);
    })
    deleteProduct.addEventListener('hidden.bs.modal', event => {
        let  form = document.getElementById("formDeleteProduct");
        form.reset();
        $('.alert').empty();
        $('.alert').css('top', '-1000px');     
    })
});

//form eliminar productos
$(document).ready(function() {
    $('#formDeleteProduct').on('submit', function(event) {
        event.preventDefault();
        
        let formData = $("#formDeleteProduct").serialize();
        let deleteProduct = document.getElementById('deleteProduct');

        $.ajax({
            type: "POST",
            url: 'php/crud/deleteProduct.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                    loadProducts();
                    let modalDeleteProduct = bootstrap.Modal.getInstance(deleteProduct);
                    modalDeleteProduct.hide();
                }else{
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                }
                
            }
        });

    });
});




//--------------------------------------------------USUARIOS--------------------------------------------------//
//cargar productos
function loadUsers() {

    $.ajax({ 
        url: "php/load/loadUsers.php",
        type: "POST"
    })
    .done(function(data) {
        let datos = JSON.parse(data);
        let dataa = "";

        datos.forEach(dato => {
            dataa += `
            <tr class="pointer rowTD" data-bs-toggle="modal" data-bs-target="#updateUser" data-id="${dato.id}">
                <td> ${dato.name} </td>
                <td> ${dato.user} </td>
                <td> ${dato.email} </td>
                <td> ${dato.permissions} </td>
                <td>
                    <button type="button" class="btn btn-danger btn-icon-text" data-bs-toggle="modal" data-bs-target="#deleteUser" data-id="${dato.id}">
                        <i class="mdi mdi-delete-forever btn-icon-prepend"></i>Eliminar 
                    </button>
                </td>
            </tr>
            `;
        });
        $("#users").html(dataa); 
    })
};

//form subir usuario
$(document).ready(function() {
    $('#formUploadUser').on('submit', function(event) {
        event.preventDefault();
        
        let formData = $("#formUploadUser").serialize();

        $.ajax({
            type: "POST",
            url: 'php/crud/uploadUser.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                    loadUsers();
                    let  form = document.getElementById("formUploadUser");
                    form.reset();
                }else{
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                }
                
            }
        });

    });
});

//modal editar usuario
$(document).ready(function(){  
    let updateUser = document.getElementById('updateUser')
    updateUser.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget
        let id = button.getAttribute('data-id')
        $.ajax({
            url: 'php/modal/modalUser.php',
            method: 'POST',
            data: { id: id }
        })
        .done(function(data) {
            let datos = JSON.parse(data);
            if (datos.length > 0) {
                let dato = datos[0];
                $("#formUpdateUser input[name='id']").val(dato.id);
                $("#formUpdateUser input[name='name']").val(dato.name);
                $("#formUpdateUser input[name='user']").val(dato.user);
                $("#formUpdateUser input[name='email']").val(dato.email);
                if (dato.permissions == 'admin') {
                    $("#formUpdateUser select[name='permissions']").append('<option value="admin">Administrador</option>');
                    $("#formUpdateUser select[name='permissions']").append('<option value="user">Sin permisos</option>');
                }else if (dato.permissions == 'user') {
                    $("#formUpdateUser select[name='permissions']").append('<option value="user">Sin permisos</option>');
                    $("#formUpdateUser select[name='permissions']").append('<option value="admin">Administrador</option>');
                }
            }
        });
    })
    updateUser.addEventListener('hidden.bs.modal', event => {
        let  form = document.getElementById("formUpdateUser");
        form.reset();
        $("#formUpdateUser select[name='permissions']").empty();
        $('.alert').empty();
        $('.alert').css('top', '-1000px');
    })
});

//form actualizar usuario
$(document).ready(function() {
    $('#formUpdateUser').on('submit', function(event) {
        event.preventDefault();
        
        let formData = $("#formUpdateUser").serialize();

        $.ajax({
            type: "POST",
            url: 'php/crud/updateUser.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                    loadUsers();
                }else{
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                }
                
            }
        });

    });
});

//modal eliminar usuario
$(document).ready(function(){  
    let deleteUser = document.getElementById('deleteUser')
    deleteUser.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget
        let id = button.getAttribute('data-id')
        $("#formDeleteUser input[name='id']").val(id);
    })
    deleteUser.addEventListener('hidden.bs.modal', event => {
        let  form = document.getElementById("formDeleteUser");
        form.reset();
        $('.alert').empty();
        $('.alert').css('top', '-1000px');     
    })
});

//form eliminar usuario
$(document).ready(function() {
    $('#formDeleteUser').on('submit', function(event) {
        event.preventDefault();
        
        let formData = $("#formDeleteUser").serialize();
        let deleteUser = document.getElementById('deleteUser');

        $.ajax({
            type: "POST",
            url: 'php/crud/deleteUser.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                    loadUsers();
                    let modalDeleteUser = bootstrap.Modal.getInstance(deleteUser);
                    modalDeleteUser.hide();
                }else{
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                }
                
            }
        });

    });
});




//--------------------------------------------------RECUPERAR CONTRASEÑA--------------------------------------------------//

// form recuperar contraseña
$(document).ready(function() {
    $('#formRecoverPassword').on('submit', function(event) {
        event.preventDefault();
        
        let formData = $("#formRecoverPassword").serialize();

        $.ajax({
            type: "POST",
            url: 'php/recoverPassword/sendMail.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000);
                }else{
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000); 
                }
            }
        });

    });
});

function loadrecoverPassword() {

    let Url = new URL(window.location.href);
    let token = Url.searchParams.get('token');
    let data = {
        uuid: token
    };

    $.ajax({ 
        url: "php/recoverPassword/validateToken.php",
        type: "POST",
        data: data,
    })
    .done(function(data) {
        $("#recoverPassword").html(data); 
    })
};

// form cambiar contraseña
$(document).ready(function() {
    $('#recoverPassword').on('submit', '#formUpdatePassword', function(event) {
        event.preventDefault();
        
        let formData = $("#formUpdatePassword").serialize();

        $.ajax({
            type: "POST",
            url: 'php/recoverPassword/updatePassword.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                        window.location.href = "login";
                    }, 7000);
                }else{
                    $('#alert').html(response.message);
                    $('#alert').css('top', '25px');
                    setTimeout(function(){
                        $('#alert').css('top', '-500px');
                    }, 4000); 
                }
            }
        });

    });
});






   
