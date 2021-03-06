# The EmoteCommands Plugin

![Plugin Icon](assets/icon.png)

<div align="center"><strong><p>This Plugin runs commands when a player does a certain emote</p><p>You will need a pocketmine server of at least version 4.0.0</strong></div>

# Usage

An EmoteCommand is a list of commands and an emote that runs those commands. **Every emote may only have one EmoteCommand for it.**

- `/makeemotecommand <name>` create new EmoteCommand with that `name`
- `/editemotecommand <name>` edit EmoteCommand named `name`
- `/removeemotecommand <name>` remove EmoteCommand named `name`

# TODOs

- [x] Load commands to run from config file
- [x] Create command to manage emote-commands

# Future Improvements

- [ ] Run commands as server
- [ ] Have players change what emote fires an EmoteCommand for them
