using IUTGame.Fake;
using MaimLandProject.Metier;
using MaimLandProject.Metier.Food;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TestUnitaireProjet
{
    public class TestCollide
    {
        [Fact]
        public void testPersonnageEtMonstre()
        {
            FakeScreen screen = new FakeScreen();
            LeJeu game = new LeJeu(screen);
            double x = 100;
            double y = 100;

            Personnage joueur = new Personnage(x, y, game);

            Monstre monstre = new Monstre(x, y, game);

            game.AjouterObjetEtJeu(joueur);
            game.AjouterObjetEtJeu(monstre);

            int directionMAvant = monstre.Direction;

            monstre.CollideEffect(joueur);
            joueur.CollideEffect(monstre);

            Assert.NotEqual(directionMAvant, monstre.Direction);
            Assert.True(joueur.IsInvincible);

        }

        [Fact]
        public void testPersonnageEtFood()
        {
            FakeScreen screen = new FakeScreen();
            LeJeu game = new LeJeu(screen);
            double x = 100;
            double y = 100;

            Personnage joueur = new Personnage(x, y, game);

            FoodCreate foodCreate = new FoodCreate(game, 1);
            FoodItem foodItem = new FoodItem(x, y, game, foodCreate);

            game.AjouterObjetEtJeu(joueur);

            FoodItem.EatCount = 0;


            foodItem.CollideEffect(joueur);
            joueur.CollideEffect(foodItem);

            Assert.True(foodItem.IsEaten);
            Assert.True(joueur.IsEating);
            Assert.Equal(1, FoodItem.EatCount);

        }

    }
}
