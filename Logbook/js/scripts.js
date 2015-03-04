// Global utility scripts go here.

$(document).ready(function(){
	$("#signUpButton").click(function(){
		var username = $("input[name='username']").val();
		var email = $("input[name='email']").val();
		var password = $("input[name='password']").val();

		if(username.length == 0 || email.length == 0 || password.length == 0){
			$.notify("Please fill all required fields", "warn")
			return false;
		}
		if(password.length > 15 || password.length < 5){
			$.notify("Password length must be between 5 and 15", "warn");
			return false;
		}
  		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
 		if(!regex.test(email)){
 			$.notify("Email is not valid", "warn");
 			return false
 		}
 		regex = /^([a-zA-Z0-9_.])/;
 		if(!regex.test(username)){
 			$.notify("Username is not valid", "warn");
 			return false;
 		}

 		$.ajax({
 			url:"inc/register.php",
 			type:"post",
 			data:{
 				"username":username,
 				"email":email,
 				"password":password
 			}	
 		})
 		.done(function(response){
 			response = response.trim();
 			if(response == "-1"){
 				$.notify("Something unforseen has happened", "error");
 			}else if(response == "-2"){
				$.notify("Email is already in use", "warn");
 			}else if(response == "-3"){
				$.notify("Username is already in use", "warn");
 			}else if(parseInt(response) > 0){
				$.notify("Successfully registered, redirecting...", "success");
				setTimeout(function(){
					location.href = "home.php";
				}, 2000);
 			}else{
 				console.log(response);
 			}
 		})
	})

	//logout
	$("#logoutButton").click(function(){
		$.ajax({
 			url:"inc/login.php",
 			type:"post",
 			data:{
 				"logout":"1"
 			}	
 		}).done(function(response){
 			$.notify("Bye!", "success");
 			setTimeout(function(){
 				location.href = "index.php";
 			}, 1000)
 		})
	})
})






var logbookIDCounter = 0;     // Keeps track of the id number given to logbooks.
var idCounter = 0;            // Keeps track of the id number given to logbook entries.
var logbooks = [];            // This keeps an array of every logbook created so far.
var createNewLogbook = false; // Decides whether or not to create a new logbook when saving.

// Creates a logbook and settings button in the left selection pane.
function createLogbook ()
{
  var logbookID       = "logbook" + logbookIDCounter;
  var logbookDiv      = document.createElement ("div");
  var logbookButton   = document.createElement ("button");
  var settingsButton  = document.createElement ("button");

  // Creates the container div for the logbook and settings button.
  logbookDiv.setAttribute ("class", "logbookContainer");
  logbookDiv.id = logbookID;
  document.getElementById("logbookSelectionPane").appendChild (logbookDiv);

  // Creates the logbook button and adds it to the new div.
  logbookButton.setAttribute ("class", "logbookButton");
  logbookButton.setAttribute ("type", "button");
  logbookButton.innerHTML = "Test text";
  document.getElementById(logbookID).appendChild (logbookButton);

  // Creates the logbook settings button and adds it as well.
  settingsButton.setAttribute ("class", "settingsButton");
  settingsButton.setAttribute ("type", "button");
  settingsButton.onclick = partial (toggleLogbookSettings, true);
  document.getElementById(logbookID).appendChild (settingsButton);

  // logbookIDCounter is incremented (guarantees each entry id is unique).
  logbookIDCounter++;
}

// Creates a logbook entry in the right editor pane.
function createLogbookEntry ()
{
  var entryDiv      = document.createElement ("div");
  var entryHeader   = document.createElement ("div");
  var entryContent  = document.createElement ("div");
  var entryID       = "entry" + idCounter;

  // Creates the container div and sets its id so the other divs can be placed
  // inside.
  entryDiv.setAttribute ("class", "entryContainer");
  entryDiv.id = entryID;
  document.getElementById("logbookEditorSpace").appendChild (entryDiv);

  // Adds the inner divs inside of the new container div.
  entryHeader.setAttribute ("class", "entryHeader");
  entryHeader.innerHTML = "More test text";

  entryContent.setAttribute ("class", "entryContent");
  document.getElementById(entryID).appendChild (entryHeader);
  document.getElementById(entryID).appendChild (entryContent);

  // idCounter is incremented (guarantees each entry id is unique).
  idCounter++;
}

// Opens the logbook settings popup.
function toggleLogbookSettings (isOn)
{
  var display = "";
  if (isOn) {
    display = 'block';
  } else {
    display = 'none'
  }

  document.getElementById("settings").style.display = display;
  document.getElementById("blanket").style.display = display;
}

// Saves the desired settings for a logbook.
function saveLogbookSettings ()
{
  toggleLogbookSettings (false)
  // If true, a logbook is created with these
  if (createNewLogbook)
  {
    createNewLogbook = false;
    createLogbook ();
  }
}

/* Code taken from: 'http://blog.dreasgrech.com/2009/11/passing-pointer-to-functi
 * on-with.html'. It allows a function reference to be passed with parameters.*/
var partial = function (func /*, 0..n args */) {
    var args = Array.prototype.slice.call(arguments, 1);
    return function () {
        var allArguments = args.concat(Array.prototype.slice.call(arguments));
        return func.apply(this, allArguments);
    }
}
