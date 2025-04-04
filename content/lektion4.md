---
ämne: Programmering
kategori: Python
titel: Lektion 4
---
# Lektion 4: Loopar - While
Det finns flera typer av loopar i python. Här tänkte jag skriva om while-loopen som är vanligast att använda när man är lite osäker på hur många gånger man vill snurra i loopen.
Ett exempel i livet är:
```python
while det_regnar==True:
    håll_paraplyet_ovanför_huvudet()
```
Syntaxen är som följer:
```python
while <villkor>:
    <gör_något>
```
Om inte variabeln i villkoret ändras i loopen kommer loopen att gå runt i all evighet.
Så man måste komma ihåg att uppdatera villkorsvariabeln.
```python
looptal=10
while looptal<20:
    print(looptal)
```
Loopar i all oändlighet. För att den skall fungera måste ci öka på variablen. 
```python
looptal=10
while looptal<20:
    print(looptal)
    looptal=looptal+1
```
Men nu är det så att om man har ett bestämt antal loop 
