<div>
    <label for="email">Email Address <span>Required</span></label>
    <input type="email" name="email" id="email" required placeholder="john.smith@gmail.com" 
        value="<?php if (isset($email)) echo $email; ?>" 
    >
</div>

<div>
    <label for="password">Password <span>Required</span></label>
    <input type="password" name="password" id="password" required 
        value="<?php if (isset($password)) echo $password; ?>" 
    />
    <div>
        <input type="checkbox" id="show" onchange="toggleShowPassword()">
        <label for="show">Show password</label>
    </div>
</div>
