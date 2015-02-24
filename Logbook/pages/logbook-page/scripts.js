// Keeps track of the id number given to logbook entries.
var idCounter = 0;

// Creates a logbook button in the left selection pane.
function createLogbook ()
{
  var button = document.createElement ("button");
  button.setAttribute ("class", "logbookButton");
  button.setAttribute ("type", "button");
  button.innerHTML = "Test text";
  document.getElementById("logbookSelectionPane").appendChild (button);
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
