<h1 align="center">KygekPingTPS</h1>

<p align="center">
<a href="https://poggit.pmmp.io/p/KygekPingTPS"><img src="https://poggit.pmmp.io/shield.dl.total/KygekPingTPS?style=for-the-badge" alt="poggit" /></a>
<a href="https://github.com/thebigcrafter/KygekPingTPS/blob/main/LICENSE"><img src="https://img.shields.io/github/license/thebigcrafter/KygekPingTPS?style=for-the-badge" alt="license" /></a>
<a href="https://discord.gg/PykBfE2TZ9"><img src="https://img.shields.io/discord/1087729577004122112?color=7289DA&label=discord&logo=discord&style=for-the-badge" alt="discord" /></a>
</p>

# 📖 About

A PocketMine-MP plugin to check the server TPS and other players' ping. This plugin will be useful if you need to check the server TPS by command or check your or other players' network ping.

# ✅ Requirements

- PocketMine-MP API 5.0.0 or a compatible API 5 release.
- [Hydrogen](https://github.com/thebigcrafter/Hydrogen) is used for the update-check and configuration-maintenance helpers declared by the Poggit manifest.

The plugin checks TPS through the server API and reads player ping from the active network session. The `/ping` command can be used by the console with a player name; a player can query their own ping or another online player when the command permission allows it. The `/tps` command is available to command senders with its permission.

# 🧩 Features

- Check server TPS using command
- Check your network ping using command
- Check other players' network ping using command
- Works in console
- Invalid player name detection
- Customizable command messages
- Automatic plugin updates checker
- Commands messages instantly updated after change

# ⬇️ Installation

1. Download the latest version (It is recommended to always download the latest version for the best experience, except you're having compatibility issues).
2. Put the `KygekPingTPS.phar` file into the `plugins` folder.
3. Restart the server.
4. Done!

# 📜 Commands & Permissions

| Command          | Description              | Permission           | Default |
| ---------------- | ------------------------- | ------------------- | ------- |
| `/ping [player]` | Current ping of a player  | `kygekpingtps.ping` | true    |
| `/tps`           | Current TPS of the server | `kygekpingtps.tps`  | true    |

💡 Tips:
- Use `-kygekpingtps.ping` to blacklist the `/ping` command permission.
- Use `-kygekpingtps.tps` to blacklist the `/tps` command permission in PurePerms.

# ⚙️ Configuration

After the first start, edit `plugin_data/KygekPingTPS/config.yml` to customize the prefix and messages. The placeholders `{prefix}`, `{player}`, `{ping}` and `{tps}` are supported by the corresponding message fields, and `&` can be used for formatting codes. Leave a message empty to use the built-in default. Keep `config-version` unchanged; the plugin uses it for configuration migration.

# 🚢 Other Versions

- [Nukkit](https://github.com/KygekTeam/KygekPingTPS-Nukkit)
- [SpigotMC/PaperMC](https://github.com/KygekTeam/KygekPingTPS-Spigot)

# ⚖️ License

Licensed under the [GNU General Public License v3.0](https://github.com/thebigcrafter/KygekPingTPS/blob/main/LICENSE) license.

# 🛠️ Development

Install the locked development dependencies and run the maximum-level analysis before submitting changes:

```shell
composer install
composer run analyse
```

The Poggit manifest remains the packaging path for this plugin. DevTools is used by the packaging environment to assemble and validate the plugin; this README intentionally describes that function without copying a builder revision.
