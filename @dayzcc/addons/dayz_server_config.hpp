//=================================================================================
// DayZ Server Configuration by Crosire
//
//=================================================================================

// Enable player model check
#define CheckModel true
// Enable custom inventory
#define CheckCustInv true
// Enable object publishing check
#define CheckObject true

// Enable kill messages
#define KillMsgs true
#define KillMsgsIngame true
// Enable hit messages
#define HitMsgs true
#define HitMsgsIngame true

// Switch between old and new way of spawning
// OldSpawn true  - Wrecks, crashsites and care packages have there own sqf files and you can change the loot inside
// OldSpawn false - Everything is in "server_spawnWreck", wrecks randomly de-/respawn while the server is running
#define OldSpawn true

// Spawn helicopter crashsites
#define SpawnHelis true
#define SpawnHelisCount 5
// Spawn random other wrecks
#define SpawnWrecks true
#define SpawnWrecksCount 18
// Spawn care packages
#define SpawnCare true
#define SpawnCareCount 4

//=================================================================================