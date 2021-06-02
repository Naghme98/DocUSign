function clearAllInputs() {
    var ancestor = document.getElementById('contract_content'),
        descendents = ancestor.getElementsByTagName('*');

    var i, e;
    for (i = 0; i < descendents.length; ++i) {
        e = descendents[i];
        if(e.id.includes("input_")){
            document.getElementById(e.id).value='';
        }
    }
}

function send(dataObject,address,name) {
    const form = document.createElement('form');
    form.method = 'post';
    form.action =address;
    const hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = name;
    hiddenField.value = dataObject;
    form.appendChild(hiddenField);
    document.body.appendChild(form);
    form.submit();
}

function loadFile(event) {
    var image = document.getElementById('signature');
    image.src = URL.createObjectURL(event.target.files[0]);
}

$(document).ready(function(){
    $("#create-key").click(function(){
        $("#modal_confirm").modal();
    });
});

$(document).ready(function(){
    $("#add-extra-party-contract").click(function(){

        let div = document.createElement("div");
        div.classList.add('form-row');
        let div2 = document.createElement("div");
        div2.classList.add('col-7');
        let input = document.createElement("input");
        input.type = 'email';
        input.classList.add('form-control');
        input.classList.add('inputs');
        div.style.paddingTop = '2%';
        input.id='contract-party-'+lastID();
        input.name = input.id;
        div2.appendChild(input);
        div.appendChild(div2);
        document.getElementById('emails-contract-parties').appendChild(div);

    });
});

function lastID(){
    let ancestor = document.getElementById('emails-contract-parties'),
        descendents = ancestor.getElementsByTagName('*');
    let temp,max=0,c ;
    for(let i=0; i<descendents.length; i++){
        temp = descendents[i];
        if(temp.id.includes('contract-party-')){

            c = temp.id.substr(temp.id.lastIndexOf('-')+1);
            if(c >max)
                max = parseInt(c);
        }
    }
    return max+1;
}

$('#confirmation').on('submit',function(event){
    $('#place').css("display", "block");
    event.preventDefault();
    $.ajax({
        url	:	"../php files/ConfirmUser.php",
        method:	"POST",
        data	: $('#confirmation').serialize(),
        success	:function(data){
            // console.log("** : "+$('#email-confirm').value);
            if(data !== "confirm_success"){
                $("#panel-footer").show();
                $("#e_msg").html('رمز عبور اشتباه است');
                $(".overlay").hide();
            }
            else {
                // let ym = $('#email-confirm').value;
                let ym = document.getElementById('email-confirm').value;
                // console.log('this is person email: '+ym);
                send(ym, "../php files/GeneratePublicPrivateKey.php",'email');
            }
        }
    });
});


// $(function () {
//     $('input').iCheck({
//         checkboxClass: 'icheckbox_square-blue',
//         radioClass   : 'iradio_square-blue',
//         increaseArea : '20%' // optional
//     })
// })