# Team Up 
## Features    
    *Add Users
    *Add groups and assign users to groups
    *Add Doc pages (posts)
    *Manage what docs users can and can't see with permissons
    *Add files to share with posts

## Database
    *Users
        *belongsToMany Groups
        *hasMany Permissions
        *hasMany Posts
        *belongsTo Edits
        *hasMany Files
    *Groups
        *hasMany Users
        *hasMany Permissions
        *hasMany Files
    *Permissions
        *belongsToMany Users
        *hasMany Posts
    *Posts
        *belongsToMany Permissions
        *belongsTo Users
        *hasMany Edits
        *belongsToMany Permisssons
    *Edits
        *hasOne Users
        *belongsTo Posts
    *Files
        *belongsTo Users
        *belongsTo Groups

