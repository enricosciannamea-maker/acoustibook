document.addEventListener("DOMContentLoaded", () => {
    const notesField = document.getElementById("notesText");
    if (!notesField) return;

    // Carica note salvate
    const savedNotes = localStorage.getItem("acoustibook_text_notes");
    if (savedNotes) {
        notesField.value = savedNotes;
    }

    window.saveNotes = function () {
        localStorage.setItem("acoustibook_text_notes", notesField.value);
        alert("Note salvate ✔");
    };

    window.clearNotes = function () {
        notesField.value = "";
        localStorage.removeItem("acoustibook_text_notes");
    };
});
