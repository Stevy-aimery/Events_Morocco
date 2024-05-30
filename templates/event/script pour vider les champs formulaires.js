
    document.addEventListener("DOMContentLoaded", function() {
        // Sélectionnez tous les éléments de formulaire de texte et réinitialisez leurs valeurs à une chaîne vide
        document.querySelectorAll('input[type="text"]').forEach(function(input) {
            input.value = '';
        });

        // Sélectionnez tous les éléments de formulaire de date et réinitialisez leurs valeurs à une chaîne vide
        document.querySelectorAll('input[type="date"]').forEach(function(input) {
            input.value = '';
        });

        // Sélectionnez tous les éléments de formulaire de nombre et réinitialisez leurs valeurs à une chaîne vide
        document.querySelectorAll('input[type="number"]').forEach(function(input) {
            input.value = '';
        });

        // Sélectionnez tous les éléments de formulaire de zone de texte et réinitialisez leurs valeurs à une chaîne vide
        document.querySelectorAll('textarea').forEach(function(textarea) {
            textarea.value = '';
        });

        // Vous pouvez ajouter d'autres types de champs de formulaire et leurs valeurs à réinitialiser si nécessaire
    });
