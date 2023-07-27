 # The file "/var/www/html/project-06-botiga-back/config/packages/security.yaml" does not contain valid YAML: Complex mappings are not supported at line 47 (near "? Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface") in /var/www/html/projet-06-botiga-back/config/packages/security.yaml (which is being imported from "/var/www/html/projet-06-botiga-back/src/Kernel.php").

`SOLUTION :`

- Mauvaise indentation dans le `security.yaml` dans le `when@test: `
- test avec : https://codebeautify.org/yaml-validator cela peret de verifier le code si il est valide ou pas permet d'identifier l'erreur 
- Correction de l'indentation  
- Plus d'erreur