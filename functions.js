function viewTrans(id, type){
    if (document.getElementById("z") != null) {
        let menu = document.getElementById('z');
        while (menu.firstChild) {
            menu.removeChild(menu.firstChild);
        }
        menu.remove();
    }
    
    var table = document.createElement("table");
    addElement({pID:"b", tag:"table", cls:"table", id:"z"});
    addElement({pID:"z", tag:"thead", id:"head"});
    // add columns
    addElement({pID:"head", tag:"th", scope:"col", inner:"Course #"});
    addElement({pID:"head", tag:"th", scope:"col", inner:"Course ID"});
    addElement({pID:"head", tag:"th", scope:"col", inner:"Course Grade"});

    // query for grades
    arr = new Array();
    $.ajax({
        url: "./query_runner.php",
        type: "POST",
        data: {uid: id, type: "t"},
        success: function(data){
            data = JSON.parse(data);
            addElement({pID:"z", tag: "tbody", id: "tbody"});
            for (var i = 0; i < data.length; i++){
                var dynID = "tr" + i.toString();
                addElement({pID: "tbody", tag:"tr", id: dynID});
                addElement({pID: dynID, tag: "th", scope: "row", inner: i+1});
                addElement({pID: dynID, tag: "td", inner: data[i]["course"]});
                addElement({pID: dynID, tag: "td", inner: data[i]["grade"]});
            }
        }
    });
}
function addElement({pID, tag, id, scope, inner, cls, type}={}) {
    var parent = document.getElementById(pID);
    var child = document.createElement(tag);
    if (cls != null){
        child.setAttribute('class', cls);
    }
    if (id != null){
        child.setAttribute('id', id);
    }
    if (scope != null){
        child.setAttribute('scope', scope);
    }
    if (inner != null){
        child.innerHTML = inner;
    }
    parent.appendChild(child);
    return;
}
function viewF1(id, type){
    if (document.getElementById("z") != null) {
        let menu = document.getElementById('z');
        while (menu.firstChild) {
            menu.removeChild(menu.firstChild);
        }
        menu.remove();
    }
    
    var table = document.createElement("table");
    addElement({pID:document.getElementsByTagName("body")[0].id, tag:"table", cls:"table", id:"z"});
    addElement({pID:"z", tag:"thead", id:"head"});
    // add columns
    addElement({pID:"head", tag:"th", scope:"col", inner:"Course #"});
    addElement({pID:"head", tag:"th", scope:"col", inner:"Course ID"});
    addElement({pID:"head", tag:"th", scope:"col", inner:"Department"});

    // query for grades
    arr = new Array();
    $.ajax({
        url: "./query_runner.php",
        type: "POST",
        data: {uid: id, type: "f"},
        success: function(data){
            console.log(data);
            var d = JSON.parse(data);
            addElement({pID:"z", tag: "tbody", id: "tbody"});
            for (var i = 0; i < d.length; i++){
                var dynID = "tr" + i.toString();
                addElement({pID: "tbody", tag:"tr", id: dynID});
                addElement({pID: dynID, tag: "th", scope: "row", inner: i+1});
                addElement({pID: dynID, tag: "td", inner: d[i]["cid"]});
                addElement({pID: dynID, tag: "td", inner: d[i]["dep"]});
            }
            
        }
    });
    
    addElement({pID:"z", id:id, tag:"button", cls: "btn btn-primary btn-md float-left f1 a", inner: "Approve"});
    addElement({pID:"z", id:id, tag:"button", cls: "btn btn-primary btn-md float-left f1 d", inner: "Disapprove"});

        $("#"+id+".a").on("click", function(){
            $.ajax({
                    url: "./query_runner.php",
                    type: "POST",
                    data: {uid: id, type: "f1"},
                    success: function(data){
                        alert("succesfully updated!")
                        }
                    });
        });
        $("#"+id+".d").on("click", function(){
            $.ajax({
                    url: "./query_runner.php",
                    type: "POST",
                    data: {uid: id, type: "f12"},
                    success: function(data){
                        alert("succesfully updated!")
                        }
                    });
        });

    
}
function approveGrad(id) {
        document.getElementById('grad').addEventListener("click", function(){ 
            event.preventDefault();
            $.ajax({
            url: "./query_runner.php",
            type: "POST",
            data: {uid: id, type: "grad"},
            success: function(data){
                alert("succesfully updated!")
                window.location.reload(true); 
                }
            });
        });
    }		

function search_students() {
    if (document.getElementById("z") != null) {
        let menu = document.getElementById('z');
        while (menu.firstChild) {
            menu.removeChild(menu.firstChild);
        }
        menu.remove();
    }
    let search_term = document.getElementById("search_bar").value;
    search_term = search_term.toLowerCase();

    let rows = document.getElementsByClassName("tab_row");
    var i = 0;
    var j;

    for (i = 0; i < rows.length; i++){

            if (!rows[i].cells[1].innerHTML.toLowerCase().includes(search_term)){
                rows[i].style.display = "none";
            } else {
                rows[i].style.display = "";
            }
    }
}
function assignAdvisor(s_uid, a_uid) {
    console.log("hi");
    $.ajax({
            url: "./set_advisor.php",
            type: "POST",
            data: {s_uid: s_uid, a_uid: a_uid},
            success: function(data){
                alert("succesfully updated!")
            }
    });
}

function search_all() {
    let search_term = document.getElementById("search_bar").value;
    search_term = search_term.toLowerCase();

    let rows = document.getElementsByClassName("tab_row");
    var i = 0;
    var j;

    for (i = 0; i < rows.length; i++){	
            if (!rows[i].cells[1].innerHTML.toLowerCase().includes(search_term)){
                rows[i].style.display = "none";
            } else {
                rows[i].style.display = "";
            }
    }
}

function redirect(id, type) {
    let tab1 = document.getElementById("tab1");

    let tab2 = document.getElementById("tab2");

    tab1.style.display = "none";
    tab2.style.display = "none";

    document.getElementsByTagName('h1')[0].style.display = 'none';
    document.getElementsByTagName('h1')[1].style.display = 'none';


    $.ajax({
            url: "./view_user_account.php",
            type: "POST",
            data: {uid: id, type: type},
            success: function(data){
                
                // Parse input from ajax request into something iterable
                data = JSON.parse(data);
                const keys = Object.keys(data[0]);

                // Create form 
                var body = document.getElementsByTagName("BODY")[0];
                var body_id = body.id;
                addElement({pID: body_id, tag: "form",id: "form"});
                
                // add necessary elements
                for (var i = 0; i < keys.length; i++) {
                    var k = keys[i];
                    var f_id = "f_" + i.toString();
                    var l_id = "l_" + i.toString();
                    var l_text = getLabelText(k);
                    console.log(k);
                    addElement({pID: "form", tag: "div", cls: "for-group", id: f_id});
                    addElement({pID: f_id, tag: "label", inner: l_text, for: i, id: l_id});
                    addElement({pID: f_id, tag: "input", cls: "form-control", id: i});
                    
                    
                    var pholder = data[0][k];
                    console.log(data);
                    if (!pholder) {
                        pholder = "No";
                    }
                    document.getElementById(i).setAttribute('placeholder', pholder);
                    document.getElementById(i).setAttribute('onkeypress', "return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)");
                }
                document.getElementById(0).setAttribute('readonly', true);
                // uid
                
                
                addElement({pID: "form", tag: "button", cls: "btn btn-primary btn-md float-left f1", id: "submit_user_info", type: "submit", inner: "Save and Exit"});
                document.getElementById("submit_user_info").addEventListener("click", function(){ 
                    var dict = [{}];
                    var obj = {};
                    var inputValues = $( ".form-control" );
                    for (var i = 0; i < keys.length; i++) {
                        var key2 = keys[i];
                        var inp = inputValues[i+1].value;
                        if (inp === "") {
                            inp = inputValues[i+1].placeholder;
                        }
                        obj[key2] = inp;
                        
                    }
                    dict.push(obj);
                    var y = dict[1]['title'];
                    $.ajax ({
                        url: "./update_user_info.php",
                        type: "POST",
                        data: {data: dict, type: type},
                        success: function(data){
                            
                        }
                    });
                });

            }
        });
}

function addElement({parent, pID, tag, id, scope, inner, cls, type, fr}={}) {
    if (parent == null){
        var parent = document.getElementById(pID);
    }
    
    var child = document.createElement(tag);
    if (cls != null){
        child.setAttribute('class', cls);
    }
    if (id != null){
        child.setAttribute('id', id);
    }
    if (scope != null){
        child.setAttribute('scope', scope);
    }
    if (inner != null){
        child.innerHTML = inner;
    }
    if (fr != null){
        child.setAttribute('for', fr);
    }
    parent.appendChild(child);
    return;
}

function getLabelText(label) {
    switch (label) {
        case "uid":
            return "UID: ";
            break;
        case "uname":
            return "Username: ";
            break;
        case "fname":
            return "First Name: ";
            break;
        case "lname":
            return "Last Name: ";
            break;
        case "email":
            return "Email: ";
            break;
        case "grad_status":
            return "Grad Status: ";
            break;
        case "thesis":
            return "Thesis: ";
            break;
        case "audited":
            return "Audited: ";
            break;
        case "program":
            return "Program: ";
            break;
        case "dep":
            return "Department: ";
            break;
        case "add":
            return "Address: ";
            break;
        case "Title":
            return "Title: ";
            break;
        case "pass":
            return "Password: ";
            break;
    }
}
