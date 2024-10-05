# Manual de teoria examen 1

## Introducció a PHP

PHP és un llenguatge del costat del servidor dissenyat per crear pàgines web dinàmiques. A diferència de HTML estàtic, que només mostra contingut fix, PHP permet que les pàgines es modifiquin en temps real, interactuant amb l'usuari, manipulant dades, o mostrant resultats segons la informació emmagatzemada en un servidor.

### 1. Variables en PHP

Les variables són fonamentals en qualsevol llenguatge de programació. En PHP, les variables es declaren amb el símbol `$` seguit del nom de la variable. El nom de la variable no pot començar amb un número i és sensible a majúscules i minúscules.

```php
$nom = "Albert";
$edat = 25;
```

#### Tipus de dades

PHP és un llenguatge de tipat dinàmic, la qual cosa significa que no cal especificar el tipus de dades de la variable. Tot i això, PHP té diversos tipus de dades comuns:

- **Strings:** Cadenes de text, com ara `$nom = "Albert";`
- **Números enters:** Per a valors numèrics, com ara `$edat = 25;`
- **Booleans:** Per a valors cert/fals, com ara `$actiu = true;`

### 2. echo en PHP

El `echo` s'utilitza per imprimir contingut a la pàgina web. Pot ser text simple o el valor d'una variable.

```php
echo "Hola món!";  // Imprimeix text
echo $nom;         // Imprimeix el valor de la variable $nom
```

També pots utilitzar el `echo` per imprimir fragments d'HTML, tal com hem vist abans.

### 3. Condicionals: if, else if, else

Els condicionals són necessaris per executar diferents blocs de codi en funció de certes condicions. Les estructures més comunes són `if`, `else if` i `else`.

```php
if ($edat >= 18) {
    echo "Ets major d'edat.";
} else {
    echo "Ets menor d'edat.";
}
```

També pots utilitzar condicions múltiples amb `else if`:

```php
if ($edat >= 18) {
    echo "Ets major d'edat.";
} else if ($edat >= 13) {
    echo "Ets adolescent.";
} else {
    echo "Ets menor de 13 anys.";
}
```

### 4. Bucles for i foreach

Els bucles permeten repetir una tasca diverses vegades. PHP ofereix diversos tipus de bucles, però els més utilitzats són el `for` i el `foreach`.

#### Bucle for

El bucle `for` és ideal quan sabem exactament quantes vegades volem repetir el codi.

```php
for ($i = 0; $i < 5; $i++) {
    echo "Número: $i<br>";
}
```

#### Bucle foreach

El `foreach` s'utilitza per recórrer tots els elements d'un array:

```php
$fruites = ["poma", "plàtan", "taronja"];
foreach ($fruites as $fruita) {
    echo $fruita . "<br>";
}
```

### 5. Mescla d'HTML i PHP

Una de les característiques més potents de PHP és la seva integració amb HTML. Això permet que les pàgines HTML estàtiques puguin incloure codi dinàmic.

#### Manera 1: Incrustar PHP dins d'HTML

Quan necessitem generar contingut dinàmic dins d'una pàgina HTML, podem incloure blocs de PHP dins d'un arxiu `.php`. Només necessitem utilitzar les etiquetes d'obertura i tancament de PHP (`<?php ... ?>`) per indicar que volem executar codi PHP.

```html
<!DOCTYPE html>
<html>
<body>
    <h1>Benvingut <?php echo $nom; ?>!</h1>
    <p>Avui és: <?php echo date('d/m/Y'); ?></p>
</body>
</html>
```

En aquest exemple, el contingut de les variables `$nom` i la data actual es genera dinàmicament.

#### Manera 2: Obrir i tancar PHP segons necessitat

Pots alternar fàcilment entre codi PHP i HTML. Només cal que obris i tanquis blocs de PHP quan necessitis afegir lògica dinàmica.

```html
<!DOCTYPE html>
<html>
<body>
    <?php if ($edat >= 18) { ?>
        <p>Benvingut, ets major d'edat.</p>
    <?php } else { ?>
        <p>Ho sento, ets menor d'edat.</p>
    <?php } ?>
</body>
</html>
```

En aquest cas, estem barrejant PHP dins de blocs HTML i controlant quins elements de la pàgina mostrar basant-nos en la condició definida en PHP.

### 6. Generar HTML dins de PHP amb echo

Una altra manera de combinar HTML amb PHP és generar l'HTML dins d'un `echo`. Això pot ser útil quan necessitem crear contingut dinàmic dins de PHP. Aquí és on la concatenació és crucial, especialment si volem afegir variables dins de l'HTML.

#### Concatenació de variables dins de echo

Quan crees contingut HTML dins de PHP, has de tenir en compte com ajuntar (concatenar) text amb variables:

- **Concatenació amb punts (`.`):** S'utilitza per combinar cadenes de text en PHP.

```php
<?php
$nom = "Albert";
echo "<h1>Benvingut, " . $nom . "!</h1>";
?>
```

- **Ús de claudàtors per a variables en cadenes:** També es pot utilitzar la notació `{$variable}` per inserir variables directament dins d'una cadena de text.

```php
<?php
echo "<p>Hola, {$nom}, gràcies per visitar-nos!</p>";
?>
```

#### Exemple complex

**OJO AMB LA CONCATENACIÓ NO SEMPRE ÉS TAN FÀCIL**

Quan generem codi HTML dins de PHP, hem de tenir molta cura amb la concatenació i l'ús correcte de les cometes. Aquí tens un exemple que crea una taula HTML dins d'un `echo`:

```php
<?php
$fruites = ["poma", "plàtan", "taronja"];
echo "<table border='1'>";
echo "<tr><th>Fruita</th></tr>";

foreach ($fruites as $fruita) {
    echo "<tr><td>{$fruita}</td></tr>";
}

echo "</table>";
?>
```

Aquest codi PHP genera una taula HTML amb les fruites llistades. Observa com usem cometes simples `'` dins de l'HTML per evitar conflictes amb les cometes dobles `"` de PHP.

### 7. Funcions en PHP

Una funció és un bloc de codi que podem reutilitzar. Es defineix amb la paraula clau `function`.

```php
function saludar($nom) {
    echo "Hola, " . $nom;
}

saludar("Albert");  // Crida la funció amb el paràmetre "Albert"
```

### 8. Arrays: Normals, Associatius i Multidimensionals

#### 8.1. Arrays normals

Un array és una col·lecció de valors. Els arrays normals tenen un índex numèric.

```php
$fruites = ["poma", "plàtan", "taronja"];
```

#### 8.2. Arrays associatius

Els arrays associatius utilitzen claus en lloc d'índexs numèrics.

```php
$persona = [
    "nom" => "Albert",
    "edat" => 25,
    "ciutat" => "Badalona"
];
```

#### 8.3. Arrays multidimensionals

Els arrays multidimensionals són arrays que contenen altres arrays.

```php
$classes = [
    "matemàtiques" => ["Àlgebra", "Geometria"],
    "ciències" => ["Física", "Química"]
];
```

## 9. Accés i modificació d'elements d'un array

### Accés a elements d'un array

Per accedir a un element d'un array, utilitzem l'índex o la clau entre claudàtors. Per exemple:

```php
// Accés a un array normal
$fruites = ['poma', 'plàtan', 'taronja'];
echo $fruites[1]; // Imprimeix 'plàtan'

// Accés a un array associatiu
$persona = [
    'nom' => 'Albert',
    'edat' => 25,
    'ciutat' => 'Badalona'
];
echo $persona['ciutat']; // Imprimeix 'Badalona'
```

### Modificació d'elements d'un array

Podem modificar un element d'un array assignant un nou valor a l'índex o la clau desitjada.

```php
// Modificació d'un array normal
$fruites[0] = 'maduixa';
print_r($fruites); // Imprimeix ['maduixa', 'plàtan', 'taronja']

// Modificació d'un array associatiu
$persona['edat'] = 30;
print_r($persona); // Imprimeix ['nom' => 'Albert', 'edat' => 30, 'ciutat' => 'Badalona']
```

### Afegir elements a un array

Podem afegir un nou element a un array simplement utilitzant `[]`:

```php
$fruites[] = 'kiwi';
print_r($fruites); // Imprimeix ['maduixa', 'plàtan', 'taronja', 'kiwi']
```

### Recorrer un array

Podem recórrer un array amb un bucle `for` o `foreach`.

Amb `for`:

```php
$numeros = [1, 2, 3, 4, 5];
for ($i = 0; $i < count($numeros); $i++) {
    echo $numeros[$i] . '<br>';
}
```

Amb `foreach`:

```php
$numeros = [1, 2, 3, 4, 5];
foreach ($numeros as $num) {
    echo ($num * 2) . ' ';
}
```


## 10. Funcions de depuració: var_dump i print_r

### var_dump

`var_dump` és una funció que mostra informació estructurada sobre una variable, incloent el seu tipus i valor. És útil per a la depuració.

```php
$fruites = ['poma', 'plàtan', 'taronja'];
var_dump($fruites); 
// Imprimirà:
// array(3) {
//   [0]=>
//   string(4) "poma"
//   [1]=>
//   string(6) "plàtan"
//   [2]=>
//   string(7) "taronja"
// }
```

### print_r

`print_r` és una funció que imprimeix informació legible sobre una variable. És més amigable visualment que `var_dump`, però proporciona menys informació tècnica.

```php
$persona = [
    'nom' => 'Albert',
    'edat' => 25,
    'ciutat' => 'Badalona'
];
print_r($persona); 
// Imprimirà:
// Array
// (
//     [nom] => Albert
//     [edat] => 25
//     [ciutat] => Badalona
// )
```


## 9. Pas de paràmetres amb $_GET

PHP permet passar informació d'una pàgina a una altra mitjançant la URL amb la variable superglobal `$_GET`. Els paràmetres es passen afegint-los a la URL després del símbol `?`.

```html
<a href="pagina.php?nom=Albert">Clica aquí</a>
```

En la pàgina `pagina.php`, podem accedir al valor del paràmetre `nom` així:

```php
$nom = $_GET['nom'];
echo 'Hola, ' . $nom;
```

>> PER ASSOLIR CONCEPTES......

**ESTÀTIC VS DINÀMIC**
En aquest exemple veure-ho perque serveix realment php. 
En primer lloc tenim una taula normal creada amb HTML i BOOTSTRAP.
   ```
   <h2>Llista de Noms i Edats</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Edat</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Marta</td>
                <td>28</td>
            </tr>
            <tr>
                <td>Pere</td>
                <td>34</td>
            </tr>
            <tr>
                <td>Laura</td>
                <td>22</td>
            </tr>
            <tr>
                <td>Jordi</td>
                <td>30</td>
            </tr>
        </tbody>
    </table>
   ```

## Resultat
![image](https://github.com/user-attachments/assets/ec6f01b2-e05c-460f-a1af-71b6fdd69cf2)

### Però.....

Volem que la taula sigui dinàmica i qeu es contrueixi a partir de dades. No volem escriure tants TD (imagina si hi ha 400 persones quinHTML més llarg ens queda...) i tampoc volem anar canviant edats al HTML cada cop que algú faci anys... És per això que definirem noms i edats a un array associatiu i farem la taula a partir d'això. Tot el codi HTML que es repeteixi el posarem dins d'un bucle ``` foreach ``` així ens estalviem picar molt codi. 
```
<?php
// Array associatiu amb noms i edats
$persones = [
    ["nom" => "Marta", "edat" => 28],
    ["nom" => "Pere", "edat" => 34],
    ["nom" => "Laura", "edat" => 22],
    ["nom" => "Jordi", "edat" => 30]
];
?>
```
```
//codi html amb la taula
<table class="table table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Edat</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($persones as $persona) { ?>
            <tr>
                <td><?php echo $persona['nom']; ?></td>
                <td><?php echo $persona['edat']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
```

## Resultat
![image](https://github.com/user-attachments/assets/e9ddd9e2-0152-4e79-9440-884e83b8757d)





# Part 2. Exercicis tipus examen

## Exemple 1: Llista de productes amb condicional if-else

Suposem que tenim una botiga que ven diferents productes i volem mostrar una llista d'aquests productes a la pàgina web, però amb una particularitat: alguns productes estan en oferta i altres no. Així, si el producte està en oferta, mostrarem un missatge destacat.

Aquí tenim l'exemple amb un array associatiu que conté els productes, preus i si estan en oferta o no.

```php
<?php
// Array associatiu amb els productes
$productes = [
    ['nom' => 'Portàtil', 'preu' => 799.99, 'oferta' => true],
    ['nom' => 'Telèfon mòbil', 'preu' => 499.99, 'oferta' => false],
    ['nom' => 'Tauleta', 'preu' => 299.99, 'oferta' => true],
    ['nom' => 'Auriculars', 'preu' => 49.99, 'oferta' => false]
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Productes disponibles</title>
    <style>
        .producte { font-size: 18px; margin-bottom: 10px; }
        .oferta { color: red; font-weight: bold; }
    </style>
</head>
<body>

<h1>Llista de productes</h1>
<ul>
    <?php
    // Recórrer la llista de productes amb foreach
    foreach ($productes as $producte) {
        // Obtenim el nom, preu i si està en oferta
        $nom = $producte['nom'];
        $preu = $producte['preu'];
        $oferta = $producte['oferta'];

        // Comencem a crear el codi HTML per cada producte
        echo '<li class="producte">';
        echo "{$nom} - {$preu}€ ";

        // Condicional per veure si el producte està en oferta
        if ($oferta) {
            echo '<span class="oferta">(En oferta!)</span>';
        }

        echo '</li>';
    }
    ?>
</ul>

</body>
</html>
```

### Explicació:

1. **Array associatiu**: Tenim un array de productes, on cada producte és un array amb les claus `nom`, `preu` i `oferta`. La clau `oferta` és un valor booleà (`true` o `false`) que indica si el producte està en oferta.
2. **Foreach**: Recorrem tots els productes de l'array utilitzant un bucle `foreach` per generar la llista HTML.
3. **Condicional if**: Per a cada producte, comprovem si està en oferta. Si `oferta` és `true`, afegim un missatge extra i destacat amb CSS.

### Resultat:

En aquest exemple, els productes que estan en oferta apareixeran amb el text '(En oferta!)' en color vermell. La resta de productes simplement es mostren amb el seu nom i preu.

---

## Exemple 2: Generar una taula amb condicional i format dinàmic

En aquest exemple, volem crear una taula HTML que mostri una llista d'alumnes i les seves qualificacions. A més, volem destacar aquells alumnes que han aprovat (nota superior a 5) i els que no ho han fet (nota inferior a 5).

```php
<?php
// Array associatiu amb els alumnes i les seves notes
$alumnes = [
    ['nom' => 'Marta', 'nota' => 8],
    ['nom' => 'Pere', 'nota' => 4],
    ['nom' => 'Laura', 'nota' => 6],
    ['nom' => 'Jordi', 'nota' => 3],
    ['nom' => 'Anna', 'nota' => 7]
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Llista de notes</title>
    <style>
        .aprovat { background-color: lightgreen; }
        .suspes { background-color: lightcoral; }
    </style>
</head>
<body>

<h1>Notes dels alumnes</h1>
<table border="1" cellpadding="10">
    <tr>
        <th>Nom</th>
        <th>Nota</th>
        <th>Resultat</th>
    </tr>

    <?php
    // Recorrem la llista d'alumnes amb foreach
    foreach ($alumnes as $alumne) {
        $nom = $alumne['nom'];
        $nota = $alumne['nota'];

        // Condicional per determinar si l'alumne ha aprovat
        if ($nota >= 5) {
            $resultat = 'Aprovat';
            $classe = 'aprovat'; // Classe CSS per als aprovats
        } else {
            $resultat = 'Suspès';
            $classe = 'suspes';  // Classe CSS per als suspesos
        }
        ?>

        <tr class="<?php echo $classe; ?>">
            <td><?php echo $nom; ?></td>
            <td><?php echo $nota; ?></td>
            <td><?php echo $resultat; ?></td>
        </tr>

        <?php
    }
    ?>
</table>

</body>
</html>
```

### Explicació:

1. **Array associatiu**: Tenim un array d'alumnes amb les seves notes. Cada alumne és un array amb les claus `nom` i `nota`.
2. **Bucle foreach**: Recorrem els alumnes i avaluem la seva nota.
3. **Condicionals**: Utilitzem un condicional `if` per determinar si l'alumne ha aprovat o suspès. Segons el resultat, li assignem una classe CSS que canvia el color de fons de la fila de la taula.
4. **Generació de taula HTML**: A cada iteració, es crea una fila de taula (`<tr>`) amb les dades de l'alumne.

### Resultat:

Les files de la taula de l'alumne aprovat es mostraran amb un fons verd clar, mentre que les dels suspesos es mostraran amb un fons vermell clar.

---


## A ESTUDIAR !!! 😁👍
Guardeu aquest manual perquè sempre podreu recorrer a ell. 
Bona sort a tothom 
