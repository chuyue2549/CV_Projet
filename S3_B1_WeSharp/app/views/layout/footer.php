<?php
#region Methods
/** 
 * Generates the HTML footer code used on each page
 * 
 * @return string The HTML footer code
*/
function GenerateFooter(): string {
        $res = '
        </body>
        </main>
            <!-- Footer -->
            <footer>
                <section class="footer-info">
                    <div class="footer-content">

                        <!-- Contact -->
                        <div class="footer-section">
                            <h3>Contact</h3>
                            <address><p><a href="https://www.google.com/maps/place/7+Bd+Dr+Petitjean,+21000+Dijon/" target="_blank">7 Bd Dr Petitjean, 21078 Dijon</a></p></address>
                            <a href="mailto:scolarite@iut-dijon.u-bourgogne.fr"><p>scolarite@iut-dijon.u-bourgogne.fr</p></a>
                        </div>

                        <!-- Legal informations -->
                        <div class="footer-section">
                            <h3>Informations</h3>
                            <ul>
                                <li><a href="#">Conditions générales</a></li>
                                <li><a href="#">Gestions des données</a></li>
                            </ul>
                        </div>

                        <!-- Socials -->
                        <div class="footer-section">
                            <h3>Suivez-nous</h3>
                            <div class="social-icons">
                                <a href="https://www.instagram.com/iut.dijon.auxerre.nevers" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                                <a href="https://www.linkedin.com/school/iut-dijon-auxerre-nevers" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                                <a href="https://www.facebook.com/iut.dijon.auxerre.nevers" target="_blank"><i class="fa-brands fa-facebook"></i></a>                            
                            </div>
                        </div>
                    </div>


                    <div class="copyright-section">
                        <p class="copyright">© 2025 WeSharp - Projet IUT Dijon</p>
                        <p><a href="#">Mentions légales</a> | <a href="#">Politique de confidentialité</a></p>
                    </div>
                </section>
            </footer>
        </body>
        </html>';
        return $res;
    }