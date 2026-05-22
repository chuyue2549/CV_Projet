using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Controls;
using IUTGame.Fake;
using MaimLandProject.Metier;
using MaimLandProject.Metier.Food;
using Xunit;

namespace TestUnitaireProjet
{
    public class TestPersonnage
    {
        [Fact]
        public void testAnimatePersonnage()
        {
            FakeScreen screen = new FakeScreen();
            LeJeu game = new LeJeu(screen);
            double x = screen.Width / 2;
            double y = screen.Height / 2;

            Personnage joueur = new Personnage(x,y,game);

            game.AjouterObjetEtJeu(joueur);

            Assert.Equal(x, joueur.Left);
            Assert.Equal(y, joueur.Top);

        }

        [Fact]
        public void TestPeutAllerVers_IsTrue()
        {
            FakeScreen screen = new FakeScreen();
            LeJeu game = new LeJeu(screen);
            double x = screen.Width / 2;
            double y = screen.Height / 2;

            Personnage joueur = new Personnage(x, y, game);
            game.Objets.Clear();

            Assert.True(joueur.PeutAllerVers(10, 0));
        }

        [Fact]
        public void TestPeutAllerVers_IsFalse()
        {
            FakeScreen screen = new FakeScreen();
            LeJeu game = new LeJeu(screen);
            double x = screen.Width / 2;
            double y = screen.Height / 2;

            Personnage joueur = new Personnage(x, y, game);
            
            // Création l'item qui peut est colliable
            Monstre monstre = new Monstre(x + joueur.Width - 10,y,game);
            monstre.Collidable = true;

            game.AjouterObjetEtJeu(joueur);
            game.AjouterObjetEtJeu(monstre);

            Assert.False(joueur.PeutAllerVers(10, 0));


        }

        [Fact]
        public void Test_CollideEffect_Personnage_PerdreUnVie()
        {
            FakeScreen screen = new FakeScreen();
            LeJeu game = new LeJeu(screen);

            double x = screen.Width / 2;
            double y = screen.Height / 2;

            Personnage joueur = new Personnage(x, y, game);
        
            Monstre monstre = new Monstre(x, y, game);

            game.AddItem(joueur);
            game.AddItem(monstre);

            joueur.CollideEffect(monstre);

            Assert.Equal(2, joueur.Vie.Vie);
           
        }
    }
}
