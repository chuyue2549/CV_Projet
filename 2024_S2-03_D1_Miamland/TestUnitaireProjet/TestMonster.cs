<<<<<<< HEAD
﻿using IUTGame.Fake;
=======
﻿using IUTGame;
using IUTGame.Fake;
>>>>>>> bee361218e84521f75b09f38eeb10ef2df5d18f8
using MaimLandProject.Metier;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Controls;
using System.Windows.Shell;

namespace TestUnitaireProjet
{
    public class TestMonster
    {


        [Fact]
        public void Deplace_sans_obstacle()
        {
            // création d'un faux écran et d'un jeu
            var screen = new FakeScreen();
            var jeu = new LeJeu(screen);

            var monstre = new Monstre(100, 100, jeu);
            jeu.AjouterObjetEtJeu(monstre); // on ajoute le monstre dans le jeu

            // on teste s’il peut aller à droite sans obstacle
            bool resultat = monstre.PeutAllerVers(10, 0);// méthode exposée juste pour test

            // Assert
            Assert.True(resultat); // Il ne devrait pas y avoir d'obstacle
        }

        [Fact]
        public void Deplace_avec_obstacle()
        {
            // Arrange
            var screen = new FakeScreen();
            var jeu = new LeJeu(screen);

            // Création du premier monstre (celui qu’on teste)
            var monstre = new Monstre(100, 100, jeu);

            // Création d’un deuxième monstre juste en face (à droite)
            var obstacle = new Monstre(100 + monstre.Width - 10, 100, jeu); // chevauchement volontaire

            // Ajout au jeu
            jeu.AjouterObjetEtJeu(monstre);
            jeu.AjouterObjetEtJeu(obstacle);

            // on teste si le premier monstre peut avancer de 10 pixels vers la droite
            bool resultat = monstre.PeutAllerVers(10, 0);

            // Assert : on attend une collision, donc false
            Assert.False(resultat);
        }

        [Fact]
        public void testAnimatePersonnage()
        {
            FakeScreen screen = new FakeScreen();
            LeJeu game = new LeJeu(screen);
            double x = screen.Width - 116;
            double y = 100;

            Monstre monstre = new Monstre(x, y, game);

            game.AjouterObjetEtJeu(monstre);



            TimeSpan during = TimeSpan.FromSeconds(15);

            monstre.Animate(during);
            Assert.Equal(-1, monstre.Direction);

        }
    }
}
