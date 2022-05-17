# php-Wordle

Design reference and notes. 

> This document is incomplete.

--- 

- [Features](#features)
  - [Wishlist](#wishlist)
- [User story](#user-story)
  - [Overview](#overview)
  - [Start](#start)
  - [New game](#new-game)
  - [Load game](#load-game)
  - [Match](#match)
  - [Statistics](#statistics)
  - [Options](#options)
- [Classes](#classes)
  - [Game()](#game)
  - [Seed()](#seed)
  - [GameMode()](#gamemode)
- [Game modes](#game-modes)

## Features

- 2 game modes
- Custom seeding for sycnhronous word selection
- On screen keyboard
- Player statistics
- Timer

### Wishlist

- [ ] Bundle with PHP binary 

## User story

### Overview

```mermaid
graph LR;
    Welcome-->Match
    Match-->Statistics
    Statistics-->Welcome
```

### Start

```mermaid
graph LR;
    Start(Start)-->Welcome
    Welcome-->LoadorNew(Load or new game?)
    LoadorNew--Yes-->IsValid[Is save valid?]
    LoadorNew--No-->SelectGameMode(Select game mode)
    IsValid--No-->SelectGameMode
    SelectGameMode-->NewGame
    IsValid--Yes-->LoadSave[Load game]
```

### New game

```mermaid
graph LR;
    NewGameRoom[New game room]-->WordSelect[Word select]
    WordSelect--Yes-->StoreWord[Store word in memory]
    StoreWord-->Match
    WordSelect--No-->End[End with error]
```

### Load game

```mermaid
graph LR;
    LoadGameRoom[Load game]-->LoadWord[Load word from save file]
    LoadWord-->Match
```

### Match

```mermaid
graph TD;
    CheckTries[While tries > 0]--TRUE-->PlayerInput(Player input)
    PlayerInput-->ValidateInput[Validate - chars, spelling]
    ValidateInput--Pass--->ParseCharacters[Parse correct characters]
    ValidateInput--Fail-->ErrorMessage[Output error message]
    ErrorMessage-->ClearFields[Clear fields]
    ClearFields[Clear fields]-->PlayerInput
    CheckTries--FALSE-->End[End match]
    ParseCharacters-->ColorCharacters[Color characters, keyboard]
    ColorCharacters-->CheckWord[Check word]
    CheckWord--Pass-->End
    CheckWord--Fail-->CheckTries 
```

### Statistics

- Played
- Win %
- Current Streak
- Max Streak
- Guess Distribution

### Options

- Hard Mode

## Classes

### Game()

```mermaid
classDiagram
    class Game {
        +int game_mode
        +int remaining_tries
        +int total_tries
        +int state
        +string seed
        +string word
    }
```

### Seed()
    
```mermaid
classDiagram
    class Seed {
        +string seed
        +int time
        +function get()
        +function load()
        +function getDaily()
    }
```

### GameMode()

- Game modes are defined in `define/gamemodes.json`.

```mermaid
classDiagram
    class GameMode {
        +string name
        +string description
        +int max_tries
        +int max_words
        +int length
        +function get()
    }
```

## Game modes

| Game mode | ID | Description |
| - | - | - |
| Daily | `0` | Daily game mode |
| Hard | `1` | Saved |
| Training | `2` | Unlimited |
