using IUTGame.Fake;
using MaimLandProject.Metier;
using MaimLandProject.Metier.Food;

namespace TestUnitaireProjet
{
    public class TestFood
    {

        [Fact]
        public void TestFoodInital()
        {
            FakeScreen screen = new FakeScreen();
            LeJeu game = new LeJeu(screen);
            FoodCreate foodCreate = new FoodCreate(game, 1);

            double x = 100;
            double y = 100;

            FoodItem foodItem = new FoodItem(x, y, game, foodCreate);

            Assert.False(foodItem.IsEaten);
            Assert.Equal("Food", foodItem.TypeName);
            Assert.Equal(x, foodItem.Left);
            Assert.Equal(y, foodItem.Top);

        }


        [Fact]
        public void TestFoodCount()
        {
            FakeScreen screen = new FakeScreen();
            LeJeu game = new LeJeu(screen);
            FoodCreate foodCreate = new FoodCreate(game, 5);
            List<FoodItem> foodItems = foodCreate.foodlist;

            Assert.Equal(5, foodItems.Count);

        }


        [Fact]
        public void TestFoodCollide()
        {
            FakeScreen screen = new FakeScreen();
            LeJeu game = new LeJeu(screen);
            FoodCreate foodCreate = new FoodCreate(game, 1);

            double x = 100;
            double y = 100;

            FoodItem foodItem = new FoodItem(x, y, game, foodCreate);
            Personnage joueur = new Personnage(x, y, game);

            foodItem.CollideEffect(joueur);

            Assert.True(foodItem.IsEaten);

        }


        [Fact]
        public void TestFoodUpdate()
        {
            FakeScreen screen = new FakeScreen();
            LeJeu game = new LeJeu(screen);
            FoodCreate foodCreate = new FoodCreate(game, 5);

            foreach(FoodItem item in foodCreate.foodlist) 
            {
                item.IsEaten = false;
            }

            foodCreate.CheckAndGreate();

            Assert.Equal(5, foodCreate.foodlist.Count);
            Assert.All(foodCreate.foodlist, f => Assert.False(f.IsEaten));

        }


    }
}