const loginForm = `<legend>
                Realize o seu login
                <form action="index.php">
                    <div class="input-container">
                      <input id="email" type="email" placeholder=" " required>
                      <label for="email">Digite seu e-mail</label>
                    </div>
                    
                    <div class="input-container">
                      <input id="password" type="password" placeholder=" " required>
                      <label for="password">Digite sua senha</label>
                    </div>
                  
                    <button type="submit">Fazer login</button>
                  </form>
                  
        </legend>`;

document.getElementById("loginForm").innerHTML = loginForm;
