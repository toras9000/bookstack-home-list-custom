#r "nuget: Lestaly, 0.67.0"
#r "nuget: Kokuban, 0.2.0"
#nullable enable
using System.Threading;
using Kokuban;
using Lestaly;
using Lestaly.Cx;

await Paved.RunAsync(async () =>
{
    var composeFile = ThisSource.RelativeFile("./docker/compose.yml");

    WriteLine(Chalk.Green["Home-List-Custom by Theme System"]);
    WriteLine();

    WriteLine(Chalk.Green["Restart containers."]);
    await "docker".args("compose", "--file", composeFile.FullName, "down", "--remove-orphans");
    await "docker".args("compose", "--file", composeFile.FullName, "up", "-d", "--wait").result().success();
    WriteLine();

    WriteLine("Container up completed.");
    var pubPort = await "docker".args("compose", "--file", composeFile.FullName, "port", "app", "80").silent().result().success().output();
    var portNum = pubPort.AsSpan().SkipToken(':').TryParseNumber<ushort>();
    var service = new Uri($"http://localhost:{portNum}");

    await CmdShell.ExecAsync(service.AbsoluteUri);
});
